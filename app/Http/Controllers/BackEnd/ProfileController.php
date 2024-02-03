<?php

namespace App\Http\Controllers\BackEnd;

use Cache;
use Auth;
use Hash;
use Session;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    function index(){
        $user = Auth::user();
        return view('back-end.profile.index', compact('user'));
    }

    function update(Request $request){
        $this->validate($request, [
            'name'              => 'required',
            'contact_number'    => 'required',
            'email'             => 'required|email|unique:users,email,' . Auth::user()->id,
            'avatar'            => 'nullable|mimetypes:image/jpeg,image/png'
        ]);

        $user                   = Auth::user();
        $user->name             = $request->name;
        $user->contact_number   = $request->contact_number;
        $user->email            = $request->email;

        if($request->hasFile('avatar')){
            $user->setFolder(public_path('/uploads/avatar'))->clearImage('avatar'); // Delete first avatar in the database then unlink in the folder
            $photo = $user->setFolder(public_path('/uploads/avatar'))->upload($request->file('avatar'), 'avatar');
            $photo->folder(public_path('/uploads/avatar'))->imageResize(160, 160);
            Cache::forget('user-avatar-' . $user->id);
        }

        $user->save();
        return back()->with('message', 'Profile Updated.');
    }


    function center(){
        $center = Branch::find(Auth::user()->branch_id);
        return view('back-end.profile.center', compact('center'));
    }

    function centerUpdate(Request $request){
        $branch = Auth::user()->branch;
        $branch->center_name            = $request->center_name;
        $branch->fax_number             = $request->fax_number;
        $branch->contact_number         = $request->contact_number;
        $branch->email_address          = $request->email_address;
        $branch->address                = $request->address;
        $branch->registration_number    = $request->registration_number;

        $branch->save();

        if($branch->domain == domainBranch()->domain){
            $key = 'domain-' . domainBranch()->domain;
            Cache::forget($key);
        }

         Session::flash('alert-class', 'alert-success');
        return back()->with('message', 'Center successfuly updated');
    }

    function changepassword(){
        return view('back-end.profile.changepassword');
    }


    function updatePassword(Request $request){
        $this->validate($request,[
            'password' => 'required|string|min:6|confirmed',
        ]);


        if (Hash::check($request->current_password, Auth::user()->password))
        {
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->password);
            $user->save();
            Session::flash('alert-class', 'alert-success');
            return back()->with('message', 'Password successfuly changed');
        }else{
            Session::flash('alert-class', 'alert-danger');
            return back()->with('warning', 'Current password is incorrect');
        }
    }
}
