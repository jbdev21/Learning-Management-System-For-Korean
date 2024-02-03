<?php

namespace App\Http\Controllers\BackEnd;

use DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\User as Teacher;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        $teachers = User::whereType('teacher')
                    ->branched()
                    ->paginate(15);
        return view('back-end.teacher.index', compact('teachers'));
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
            'username' => 'required|unique:users',
            'email' => 'nullable|unique:users',
            'password'  => 'required|confirmed'
        ]);

        $teacher                    = new Teacher;
        $teacher->name              = $request->name;
        $teacher->username          = $request->username;
        $teacher->email             = $request->email;
        $teacher->status            = $request->status;
        $teacher->type              = 'teacher';
        $teacher->is_active         = 1;
        $teacher->contact_number    = $request->contact_number;
        $teacher->branch_id         = domainBranch()->id;
        $teacher->password          = $request->password ? bcrypt($request->password) : bcrypt("password");
        $teacher->save();
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
        $teacher = Teacher::find($id);
        return view('back-end.teacher.edit', compact('teacher'));
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
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'nullable|unique:users,email,' . $id,
        ]);

        $teacher                    = Teacher::find($id);
        $teacher->name              = $request->name;
        $teacher->username          = $request->username;
        $teacher->email             = $request->email;
        $teacher->contact_number    = $request->contact_number;
        $teacher->status            = $request->status;
        $teacher->branch_id         = $request->user()->branch_id;

        if($request->password){
            $teacher->password      = $request->password ? bcrypt($request->password) : bcrypt("password");
        }

        $teacher->save();

        return redirect()->route('back-end.teacher.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->checkedItems){
            foreach($request->checkedItems as $item){
                $teacher = Teacher::find($item);
                $teacher->delete();
            }
        }else{
            if($id){
                $teacher = Teacher::find($id);
                $teacher->delete();
            }
        }

        if(!request()->ajax()){
            return back();
        }
       
    }
}
