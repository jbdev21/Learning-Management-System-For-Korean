<?php

namespace App\Http\Controllers\Student;

use Auth;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    function index(){
        $user = Auth::user();
        return view('student.profile.index', compact('user'));
    }

    function update(Request $request){
        $this->validate($request, [
            'name'              => 'required',
            // 'contact_number'    => 'required',
            // 'email'             => 'required|email|unique:users,email,' . Auth::user()->id,
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
            \Cache::forget('user-avatar-' . $user->id);
        }

        $user->save();
        return back()->with('message', 'Profile Updated.'); 
    }
    // function update(Request $request){
    //     $user = Auth::user();
    //     $user->name = 
    // }

    function changePassword(){
        return view('student.profile.changepassword');
    }

    function changePasswordPost(Request $request){
        $this->validate($request,[
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);


        if (Hash::check($request->current_password, Auth::user()->password))
        {
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->password);
            $user->save();

            Session::flash('message', 'Password successfully Changed!');
            Session::flash('alert-class', 'alert-success');
        }else{
            Session::flash('message', 'Current Password not Match!');
            Session::flash('alert-class', 'alert-danger');
        }

        return back();
    }

}
