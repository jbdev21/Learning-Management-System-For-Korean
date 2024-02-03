<?php

namespace App\Http\Controllers\BackEnd;

use Auth;
use Excel;
use DataTables;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Imports\QuizQuestionImport;
use App\Http\Controllers\Controller;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $quizzes = Quiz::branched()->latest()->get();
        return view('back-end.quiz.index', compact('quizzes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'duration' => 'required',
            'thumbnail' => 'nullable|mimes:jpeg,jpg,png,svg,JPEG,JPG,PNG,SVG'
        ]);

        $quiz = new Quiz;
        $quiz->branch_id = $request->user()->branch_id;
        $quiz->name = $request->name;
        $quiz->code = time();
        $quiz->details = $request->details;
        $quiz->duration = $request->duration;
        $quiz->category = $request->category;
        $quiz->save();

        if($request->hasFile('thumbnail')){
            $photo = $quiz->upload($request->file('thumbnail'), 'thumbnail');
            $photo->imageResize($photo->path, 940, 750);
        }
        return back();
    }



    function questionStore(Request $request){

        $quiz = Quiz::find($request->quiz);
        if($request->hasFile('excelfile')){
            try{
                \DB::transaction(function() use ($quiz, $request){
                    Excel::import(new QuizQuestionImport($quiz), $request->file('excelfile'));
                });
            }catch(\Exception $e){
                return back()->with('warning', $e->getMessage());
                return back()->with('warning', "Error found on the file you uploaded. Make sure all rules is applied and matches the correct answers");
            }


            return redirect()->route('back-end.quiz.show', $quiz->id)
                    ->with('message', 'Questions imported!');
        }

        $question = new Question;
        $question->quiz_id = $request->quiz;
        $question->body = $request->body;
        $question->answer = $request->answer ?? '';
        $question->options = $request->options;
        $question->explanation = $request->explanation;
        $question->type = $request->question_type;
        $question->case_sensitive = $request->case_sensitive ? 1 : 0;
        $question->save();

        if($request->hasFile('image_start')){
            $question->addImage('image_start', $request->file("image_start"), public_path('uploads'));
        }

        if($request->hasFile('image_end')){
            $question->addImage('image_end', $request->file("image_end"), public_path('uploads'));
        }

        if(!$request->ajax()){
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quiz = Quiz::find($id);
        $questions = $quiz->questions()->latest()->paginate(25);
        return view('back-end.quiz.show', compact('quiz', 'questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quiz = Quiz::find($id);
        return view('back-end.quiz.edit', compact('quiz'));
    }

    public function questionEdit(Request $request, $id)
    {
        $question = Question::find($id);
        $quiz = Quiz::find($question->quiz_id);

        if($request->ajax()){
            return $question;
        }

        return view('back-end.quiz.edit-question', compact('question', 'quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'thumbnail' => 'nullable|mimes:jpeg,jpg,png,svg,JPEG,JPG,PNG,SVG'
        ]);

        $quiz = Quiz::find($id);
        $quiz->name = $request->name;
        $quiz->details = $request->details;
        $quiz->duration = $request->duration;
        $quiz->category = $request->category;
        $quiz->save();

        if($request->hasFile('thumbnail')){
            // Clear and replace
            $quiz->clearImage('thumbnail');
            $photo = $quiz->upload($request->file('thumbnail'), 'thumbnail');
            $photo->imageResize(940, 750);
        }

        return redirect()->route('back-end.quiz.index');
    }


    function questionUpdate(Request $request){
        $question = Question::find($request->question_id);
        $question->body = $request->body;
        $question->answer = $request->answer ?? '';
        $question->options = $request->options;
        $question->explanation = $request->explanation;
        $question->type = $request->question_type;
        $question->case_sensitive = $request->case_sensitive ? 1 : 0;

        $question->save();
        if(!request()->ajax()){
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        $quiz->clearImage('thumbnail');
        $quiz->delete();
        if(!request()->ajax()){
            return back();
        }
    }


    public function questionDestroy($id){
        $question  = Question::find($id);
        $question->images()->each(function($q){
            $file = public_path($q->source);
            if(file_exists($file)){
                unlink(($file));
            }

            $q->delete();
        });

        $question->delete();
        if(!request()->ajax()){
            return back();
        }
    }
}
