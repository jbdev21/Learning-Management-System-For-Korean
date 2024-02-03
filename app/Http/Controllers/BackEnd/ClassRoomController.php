<?php

namespace App\Http\Controllers\BackEnd;

use Auth;
use App\Models\User;
use App\Models\Subject;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = ClassRoom::branched()   
                        ->with(['teachers', 'students', 'subjects'])
                        ->paginate(15);
        $subjects = Subject::branched()->get();
        $teachers = User::branched()->whereType('teacher')->get();
        return view('back-end.classroom.index', compact('classrooms', 'subjects', 'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    //   return view('back-end.classroom.create', compact('subjects','teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:class_rooms,name,NULL,id,branch_id,' . $request->user()->branch_id,
        ]);

        $room = new ClassRoom;
        $room->name = $request->name;
        $room->branch_id = $request->user()->branch_id;
        $room->save();

        $room->teachers()->attach($request->teachers);
        $room->subjects()->attach($request->subjects);

        return back()->with('success', 'Class Room Saving Complete!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = ClassRoom::findOrFail($id);
        // return User::where('branch_id', Auth::user()->id)->get();
        $currentStudentIds  = $room->users->pluck('id');
        $students = User::where('branch_id', Auth::user()->branch_id)->whereNotIn('id', $currentStudentIds)->where('type','student')->get();
        $teachers = User::where('branch_id', Auth::user()->branch_id)->where('type', 'teacher')->get();
        $classTeachers = $room->users()->where('type', 'teacher')->get()->pluck('id')->toArray();
        return view('back-end.classroom.show', compact('room', 'students','teachers', 'classTeachers'));
    }



    function addUser(Request $request){
        $room = ClassRoom::find($request->classroom);
        $type = $request->type ? $request->type : 'teacher';
        if($request->users){
            if(is_array($request->users)){
                $room->users()->attach($request->users);
            }else{
                $room->users()->attach([$request->users]);
            }
        }else{
            if($type == "teacher"){
                $room->users()->detach($room->users()->whereType('teacher')->get()->pluck('id')->toArray());
            }
        }

        return back();
    }

    function removeUser(Request $request, $id){
        $room = ClassRoom::find($id);
        $room->users()->detach($request->users);
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = ClassRoom::find($id);
        $subjects = Subject::branched()->get();
        $teachers = User::branched()->whereType('teacher')->get();
        return view('back-end.classroom.edit', compact('room', 'subjects', 'teachers'));
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
        $this->validate($request, [
            'name' => "required|string|unique:class_rooms,name,$id,id,branch_id," . $request->user()->branch_id,
        ]);
        
        $room = ClassRoom::find($id);
        $room->name = $request->name;
        $room->save();
        
        // making sure the detach will be each since students and teacher relationship conflicts
        $room->teachers()->each(function($q) use ($room){
            $room->teachers()->detach($q->id);
        });

        $room->subjects()->detach();
        $room->teachers()->attach($request->teachers);
        $room->subjects()->attach($request->subjects);

        return redirect()->route('back-end.class-room.index')->with('success', 'Class Room Updating Complete!');
    }

    function attachUser(Request $request){
        $user = User::find($request->user_id);
        $user->classrooms()->attach($request->classrooms);
        if(!$request->ajax()){
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
        $classroom = ClassRoom::find($id);
        $classroom->delete();
        return back();
    }
}
