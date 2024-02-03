@extends("student.includes.layouts.main")  
@section('page-title', 'Change Password')
@section('content')
        <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                        <h1>Change Password</h1>
                        @include('student.includes.alerts.error')
                        @include('student.includes.alerts.message')
                        <div class="box p-5">
                                <form action="{{ route('student.profile.changepassword.store') }}" method="POST">
                                        @csrf
                                        <p>
                                                <label for=""> Current Password</label>
                                                <input type="password" class="form-control form-control-sm" required  placeholder=" old password" name="current_password">
                                        </p>
                                        <hr>
                                        <p>
                                                <label for=""> New Password</label>
                                                <input type="password" class="form-control form-control-sm" required  placeholder="new password" name="password">
                                        </p>
                                        <p>
                                                <label for=""> Repeat Password</label>
                                                <input type="password" class="form-control form-control-sm" required  placeholder=" repeat new password" name="password_confirmation">
                                        </p>
                                        <br>
                                        <p>
                                                <button class="btn btn-warning"><i class="fa fa-save"> </i> Submit</button>
                                        </p>
                                </form>
                        </div>
                </div>
        </div>

@endsection