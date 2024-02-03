<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::all();
        return view('back-end.branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back-end.branch.create');
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
            'center_name' => 'required',
            'domain'      => ['required','unique:branches']
        ]);

        $branch                         = new Branch;
        $branch->domain                 = $request->domain;
        $branch->center_name            = $request->center_name;
        $branch->fax_number             = $request->fax_number;
        $branch->contact_number         = $request->contact_number;
        $branch->email_address          = $request->email_address;
        $branch->address                = $request->address;
        $branch->registration_number    = $request->registration_number;
        $branch->save();

        return back()->route('back-end.branch.index')->with('message', 'Branch created!');
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
        $branch = branch::find($id);
        return view('back-end.branch.edit', compact('branch'));
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
            'center_name' => 'required',
            'domain' => ['required', 'unique:branches,domain,' . $id],
        ]);

        Cache::forget('domain-' . $request->domain);

        $branch                         = Branch::find($id);
        $branch->domain                 = $request->domain;
        $branch->center_name            = $request->center_name;
        $branch->fax_number             = $request->fax_number;
        $branch->contact_number         = $request->contact_number;
        $branch->email_address          = $request->email_address;
        $branch->address                = $request->address;
        $branch->registration_number    = $request->registration_number;
        $branch->save();
        
        return redirect()->route('back-end.branch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return back();
    }
}
