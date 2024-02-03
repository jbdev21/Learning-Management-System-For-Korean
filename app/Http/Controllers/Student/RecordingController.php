<?php

namespace App\Http\Controllers\Student;

use Storage;
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
        $recordings = Recording::whereUserId(auth()->user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('student.recording.index', compact('recordings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student.recording.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = $request->file('audiofile')->storeAs('public/recordings', time().".mp3");
       
        $recording = new Recording;
        $recording->user_id = $request->user()->id;
        $recording->title = $request->title;
        $recording->script = $request->script;
        $recording->recording = $path;
        $recording->save();

        return route('student.recording.index', ['recording' => $recording->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $recording = Recording::find($id);
        return view('student.recording.show', compact('recording'));
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
        $recording = Recording::find($id);
        if(Storage::exists($recording->recording)){
            Storage::delete($recording->recording);
        }

        $recording->delete();

        return redirect()->route('student.recording.index');
    }
}
