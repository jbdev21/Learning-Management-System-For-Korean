@extends("back-end.includes.layouts.main")  

@section('page-title', ' Change Password')

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
                <li ><a href="{{ route('back-end.profile.index') }}" >Profile</a></li>
                <li class="active"><a href="{{ route('back-end.profile.changepassword') }}" >Change Password</a></li>
                @if(Auth::user()->type != "teacher")
                        <li><a href="{{ route('back-end.profile.center.index') }}" >Center</a></li>
                @endif
        </ul>
        <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                        @include('back-end.includes.alerts.message')
                        {{-- @include('back-end.includes.alerts.errors') --}}
                        <br>
                        <form action="{{ route('back-end.profile.changepassword.update') }}" method="POST">
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