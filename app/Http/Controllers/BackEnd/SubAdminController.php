<?php

namespace App\Http\Controllers\BackEnd;

use DataTables;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Yajra\DataTables\Html\Builder;
use App\Http\Controllers\Controller;

class SubAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $teachers = User::whereType('sub-administrator')->where('branch_id', auth()->user()->branch_id);

            return DataTables::of($teachers)
                ->addColumn('check', function ($teacher) {
                    return '<input type="checkbox" name="item_checked[]" value="' . $teacher->id . '" >';
                })
                ->addColumn('buttons', function ($teacher) {
                    $buttons = "";
                    $buttons = '<div class="dropdown">
                                <a class="dropdown-toggle tex-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-gear"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">';
                    $buttons .=  '<li><a href="' . route('back-end.teacher.show', $teacher->id) . '" ><i class="fa fa-eye"></i> Details</a></li>';
                    $buttons .=  '<li><a href="' . route('back-end.teacher.edit', $teacher->id) . '" ><i class="fa fa-pencil"></i> Edit</a></li>';
                    $buttons .=  '<li><a href="' . route('back-end.teacher.edit', $teacher->id) . '" ><i class="fa fa-trash"></i> Delete</a></li>';
                    $buttons .= '</ul></div>';
                    return $buttons;
                })
                ->rawColumns(['check', 'buttons'])
                ->make();
        }

        $html = $builder
            ->parameters([
                    'order' => [ [1, 'ASC'] ],
                    'pageLength' => 25,
                ])
            ->columns([
            [
                'data' => 'check',
                'name' => '',
                'title' => '<input type="checkbox" id="checkAll" >',
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'width'          => '10px'
            ],
            [
                'data' => 'username',
                'name' => 'username',
                'title' => 'Username',
                'orderable' => true, 
                'searchable' => true
            ],
            [
                'data' => 'username',
                'name' => 'username',
                'title' => 'Name',
                'orderable' => true, 
                'searchable' => true
            ],
            [
                'data' => 'contact_number',
                'name' => 'contact_number',
                'title' => 'Contact Number',
                'orderable' => true, 
                'searchable' => true
            ],
            [
                'data' => 'email',
                'name' => 'email',
                'title' => 'Email',
                'orderable' => true, 
                'searchable' => true
            ],
            [
                'data' => 'status',
                'name' => 'status',
                'title' => 'Status',
                'orderable' => true, 
                'searchable' => true
            ],
            [
                'defaultContent' => '',
                'data'           => 'buttons',
                'name'           => 'buttons',
                'title'          => '',
                'render'         => null,
                'orderable'      => false,
                'searchable'     => false,
                'exportable'     => false,
                'footer'         => '',
                'width'          => '15px'
            ],
        ]);


        $branches = Branch::all();
        $admins = User::whereType('sub-admin')->get();

        return view('back-end.sub-admin.index', compact('html','branches', 'admins'));
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
            'email' => 'required|unique:users',
        ]);

        $teacher                    = new User;
        $teacher->name              = $request->name;
        $teacher->username          = $request->username;
        $teacher->email             = $request->email;
        $teacher->type              = 'sub-administrator';
        $teacher->is_active         = 1;
        $teacher->contact_number    = $request->contact_number;
        $teacher->branch_id         = $request->branch_id;
        $teacher->password          = $request->password ? bcrypt($request->password) : bcrypt("password");
        $teacher->save();

        return back()->with('success', 'Sub Admin Added!');
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
        $subadmins = User::find($id);
        return view('back-end.sub-admin.edit', compact('subadmins'));
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
            'username' => 'required|unique:users,' . $id,
            'email' => 'required|unique:users,' . $id,
        ]);

        $teacher                    = User::find($id);
        $teacher->name              = $request->name;
        $teacher->username          = $request->username;
        $teacher->email             = $request->email;
        $teacher->type              = 'sub-administrator';
        $teacher->is_active         = 1;
        $teacher->contact_number    = $request->contact_number;
        $teacher->branch_id         = $request->branch_id;
        $teacher->password          = $request->password ? bcrypt($request->password) : bcrypt("password");
        $teacher->save();

        return back()->with('success', 'Sub Admin Updated!');
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
