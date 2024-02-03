<?php

namespace App\Http\Controllers\BackEnd;

use Auth;
use Cache;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CenterController extends Controller
{
    function index(){
        $branch  = Auth::user()->branch;
        return view('back-end.center.index', compact('branch'));
    }


    function update(Request $request, $id){
        $this->validate($request, [
            'center_name'        => 'required',
            'fax_number'        => 'required',
            'contact_number'    => 'required',
            'email_address'     => 'required',
            'logo'            => 'nullable|mimes:jpg,JPG,JPEG,png,PNG'
        ]);

        $branch = Branch::find($id);
        $branch->center_name     = $request->center_name;
        $branch->fax_number     = $request->fax_number;
        $branch->contact_number = $request->contact_number;
        $branch->email_address  = $request->email_address;

        if($branch->domain == domainBranch()->domain){
            $key = 'domain-' . domainBranch()->domain;
            Cache::forget($key);
        }

        if($request->hasFile('logo')){
            $branch->setFolder(public_path('/uploads/logo'))->clearImage('logo'); // Delete first logo in the database then unlink in the folder
            $photo = $branch->setFolder(public_path('/uploads/logo'))->upload($request->file('logo'), 'logo');
            $photo->folder(public_path('/uploads/logo'))->imageResize(60, 60);
        }

        $branch->save();

        return back()->with('success', ' Saving Complete..');
    }
}
