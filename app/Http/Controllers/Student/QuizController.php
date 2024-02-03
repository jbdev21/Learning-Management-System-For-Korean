<?php

namespace App\Http\Controllers\Student;


use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Examination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    function index(Request $request){
        $query = Quiz::query();
        Session::forget('examination');

        if($request->q){
            $query->where('name', 'LIKE', '%' . $request->q . '%');
        }

        if($request->category){
            $query->where('category', $request->category);
        }

        $quizzes = $query->whereNotIn('id', Auth::user()->quizes->pluck('id'))
                    ->whereType('grammar_exercise')
                    ->orderBy('name')
                    ->with(['lastExamination'])
                    ->withCount(['questions'])
                    ->paginate(16);

        return view('student.quiz.index', compact('quizzes'));
    }


    function show(Request $request, $code){
        Session::forget('examination');
        $quiz = Quiz::whereCode($code)->firstOrFail();
        // for Retake
        if($request->retake == 1){
            Auth::user()->answers()->whereHas('question', function($q) use ($quiz){
                    $q->whereQuizId($quiz->id);
            })->delete();
        }
        return view('student.quiz.show', compact('quiz'));
    }




    function question(Request $request, $code){

        $quiz = Quiz::whereCode($code)->firstOrFail();

        Session::forget('time');
        if(Session::has('examination')){
            $examination = Examination::find(Session::get('examination'));
        }else{
            $examination = $this->generateExamination($quiz);
        }

        $answered = $examination->answers();

        $count = $quiz->questions()->count();

        if(!$examination->quizCompleted($quiz->id)){
            $question = $quiz->questions()->whereNotIn('id', $answered->pluck('question_id'))
                    ->inRandomOrder()
                    ->with('images')
                    ->first();
        }

        if($request->ajax()){
            if(!$examination->quizCompleted($quiz->id)){
                return array(
                    'question'  => $question,
                    'questions_count' => $quiz->questions()->count(),
                    'answered' => $answered->count() + 1,
                );
            }else{
                return response()->json(['message' => 'answer saved', 'status' => 'done', 'body' => ''], 200);
            }
        }else{
            if($examination->quizCompleted($quiz->id)){
                $id = Session::pull('examination');
                Session::forget('time');
                return redirect()->route('student.quiz.result', $id);
            }
        }

        if(Session::get('time')){
            $time = Session::get('time.0');
        }else{
            $time =  date('Y-m-d H:i:s', strtotime( date('Y-m-d H:i:s') . '+' . $quiz->duration . 'minutes'));
            Session::push('time', $time);
        }

        return view('student.quiz.question', compact('quiz', 'question', 'time'));
    }


    function generateExamination(Quiz $quiz){
        $examination =  Examination::create([
            'user_id' => request()->user()->id,
            'quiz_id'   => $quiz->id,
        ]);

        Session::put('examination', $examination->id);

        return $examination;
    }


    function answerQuestion(Request $request){

        $question = Question::find($request->question_id);

        // $correct = $question->answer == $request->answer ? 1 : 0;
        $correct = $question->checkForCorrect($request->answer) ? 1 : 0;

        $result = new Answer;
        $result->user_id = $request->user()->id;
        $result->examination_id = Session::get('examination');
        $result->question_id = $request->question_id;
        $result->answer = $request->answer;
        $result->correct = $correct;
        $result->save();

        if($request->ajax()){
            return $result;
        }else{
            return back();
        }
    }

    public function result($code){
        Session::forget('examination');
        $examination = Examination::find($code);
        $quiz = $examination->quiz;
        $questions = $examination->quiz->questions;
        return view('student.quiz.result', compact('quiz', 'questions', 'examination'));
    }

    public function stop(Request $request, $code){
        $examination = Examination::find(Session::pull('examination'));
        Session::forget('time');
        $quiz = Quiz::whereCode($code)->firstOrFail();

        $answered = $examination->answers()->whereHas('question', function($q) use ($quiz){
                        $q->whereQuizId($quiz->id);
                   })->get();

        if(!$examination->quizCompleted($quiz->id)){
            $questions = $quiz->questions()->whereNotIn('id', $answered->pluck('question_id'))->get();
        }

        foreach($questions as $question){
            $result = new Answer;
            $result->user_id = $request->user()->id;
            $result->question_id = $question->id;
            $result->examination_id = $examination->id;
            $result->answer = '';
            $result->correct = 0;
            $result->save();
        }


        return redirect()->route('student.quiz.result', $examination->id);
    }

}
