<?php

namespace App\Http\Controllers\Student;

use Notification;
use App\Models\User;
use App\Models\Writing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Notifications\BackEnd\NewWritingNotification;
use App\Notifications\BackEnd\UpdateWritingNotification;
use App\Services\GrammarCheckerService;
use PhpParser\Node\Stmt\Return_;

class WritingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'book_id'       => 'required|integer',
            'component_id'  => 'required|integer',
        ]);

        $message = '';
        $admins = User::whereType('administrator')->get();
        $teachers = auth()->user()->studentTeachers();
        $sendNotif = false;

        foreach($request->except('_token','component_id', 'book_id') as $inputData){
            $mode = $inputData['mode'];
            $input = $inputData['input'];
            $inputData['data']['date_time'] = date('Y-m-d H:i:s');
            $inputData['data']['writer'] = auth()->user()->id;
            $inputData['data']['writer_type'] = 'student';

            $data =  $inputData['data'];
            $first_key = array_keys($data)[0];

            $current = Writing::where('book_id', $request->book_id)
                                ->where('component_id', $request->component_id)
                                ->where('student', auth()->user()->id);

            $withGrammarErrors = false;
            $withGrammarErrorsCorrected = false;

            if($mode == "stacked"){
                if($data[$first_key]){
                    $writing = new Writing;
                    $writing->user_id = $request->user()->id;
                    $writing->student = $request->user()->id;
                    $writing->component_id = $request->component_id;
                    $writing->book_id = $request->book_id;
                    $writing->data = $data;
                    $writing->input = $input;
                    $writing->save();

                    if(!$sendNotif){
                        // Notification::send($admins, new NewWritingNotification($writing));
                        // Notification::send($teachers, new NewWritingNotification($writing));
                        $sendNotif = true;
                    }

                    $component = Component::find($request->component_id);

                    $j = 0;
                    $inputs = $component->inputs;
                    foreach( $inputs as $element ) {
                        $inputs[$j] = strtolower($element);
                        $j++;
                    }

                    if(in_array('form', $inputs) || in_array('summary', $inputs)){

                        $inputData['data']['writer_type'] = 'teacher';
                        $teacher = Writing::where('component_id', $request->component_id)
                                            ->where('book_id', $request->book_id)
                                            ->where('student', $request->user()->id)
                                            ->first();

                        if($teacher){
                            $text=  $data['summary'];
                            $grammarReponse = (new GrammarCheckerService)->text($text)->generate();
                            if(count($grammarReponse['errorList'])){
                                $inputData['data']['summary'] = $grammarReponse['textErrors'];
                                $inputData['data']['errors'] = $grammarReponse['errorList'];
                                $inputData['data']['date_time'] = date('Y-m-d H:i:s');
                                $inputData['data']['writer'] = $teacher->user_id;
                                $inputData['data']['writer_type'] = 'teacher';

                                $teacherWriting = new Writing;
                                $teacherWriting->user_id = $teacher->user_id;
                                $teacherWriting->student = $request->user()->id;
                                $teacherWriting->component_id = $request->component_id;
                                $teacherWriting->book_id = $request->book_id;
                                $teacherWriting->data = $inputData['data'];
                                $teacherWriting->input = $input;

                                $teacherWriting->save();
                                $withGrammarErrors = true;
                            }else{
                                $withGrammarErrorsCorrected = true;
                            }

                            if(in_array($request->component_id, config('messages.form.components'))){
                                if($withGrammarErrors){
                                    $message = config('messages.form.errors.' . $request->component_id);
                                }

                                if($withGrammarErrorsCorrected){
                                    $message = config('messages.form.success.' . $request->component_id);
                                }
                            }

                        }
                    }
                }
            }else{
                if($current->where('input', $input)->exists()){
                    $writing  = $current->first();
                    $writing->data = $data;
                    $writing->save();

                     if(!$sendNotif){
                        Notification::send($admins, new UpdateWritingNotification($writing));
                        Notification::send($teachers, new UpdateWritingNotification($writing));
                        $sendNotif = true;
                    }
                }else{
                    if($data[$first_key]){
                        $writing = new Writing;
                        $writing->user_id = $request->user()->id;
                        $writing->student = $request->user()->id;
                        $writing->component_id = $request->component_id;
                        $writing->book_id = $request->book_id;
                        $writing->data = $data;
                        $writing->input = $input;
                        $writing->save();

                        if(!$sendNotif){
                            Notification::send($admins, new NewWritingNotification($writing));
                            Notification::send($teachers, new NewWritingNotification($writing));
                            $sendNotif = true;
                        }
                    }
                }

            }

        }

        if($message != ''){
            return back()->with('message', $message);
        }

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
