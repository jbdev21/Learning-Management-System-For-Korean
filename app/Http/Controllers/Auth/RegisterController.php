<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\StudentInfo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';


      public function register(Request $request)
    {
        $this->validate($request, [
            'username'  => 'required|unique:users',
            'password'  => 'required|confirmed',
            'name'      => 'required',
            'email'     => 'nullable|unique:users'
        ]);

        $student = new User;
        $student->branch_id = 1; // as temporary
        $student->username = $request->username;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->type = "student";
        $student->name = $request->name;
        $student->contact_number = $request->contact_number;
        $student->status = 'waiting';
        $student->password = $request->password ? bcrypt($request->password) : bcrypt('password');

        $student->save();

        $studentdata = new StudentInfo;
        $studentdata->ar_level = '';
        $studentdata->data = ['parent_contact_number' => '', 'school_name' => '', 'grade' => '', 'remarks'=> ''];
        $student->studentData()->save($studentdata);

        return back()->with('registration_success', 'Regisration Success');
     
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
