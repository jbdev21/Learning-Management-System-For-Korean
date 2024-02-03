<?php

namespace App\Http\Controllers\BackEnd;

use Auth;
use Storage;
use App\Models\User;
use App\Models\Recording;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()->type == "teacher"){
            $data = User::branched()->whereIn('id', $request->user()->teacher_students->pluck('id'));
        }else{
            $data = User::branched();
        }

        $data->whereHas('recordings')->get()->sortBy(function($q){
            return optional($q->recordings()->orderBy('created_at', 'DESC')->first())->created_at;
        });

        if($request->student){
            $data->where('id', $request->student);
        }
        
        if($request->student_name){
            $data->where(function($q) use ($request){
                $q->where('name', 'LIKE', '%' . $request->student_name .'%')
                ->orWhere('username', 'LIKE', '%' . $request->student_name . '%');           
            });
        }
      
        
        $students = $data->branched()->paginate(25);

        return view('back-end.recording.index', compact('students'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $student = User::find($id);
        $data = $student->recordings()->orderBy('created_at', 'DESC');
        $recordings = $data->paginate(15);

        if($request->audio){
            $activeRecord = Recording::find($request->audio);
            if($activeRecord){
                return view('back-end.recording.show', compact('student', 'recordings', 'activeRecord'));
            }else{
                // return abort(404);
                return $activeRecord = $recordings->first();
                return view('back-end.recording.show', compact('student', 'recordings', 'activeRecord'));
            }
        }else{
            $activeRecord = $recordings->first();
            return view('back-end.recording.show', compact('student', 'recordings', 'activeRecord'));
        }

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
    public function destroy(Request $request, $id)
    {
        $recording = Recording::find($id);
        $student = $request->user()->id;
        if(Storage::exists($recording->recording)){
            Storage::delete($recording->recording);
        }

        $recording->delete();

        return redirect()->route('back-end.recording.show', $student);
    }
}
