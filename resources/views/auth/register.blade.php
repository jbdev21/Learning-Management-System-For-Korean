@extends('layouts.website')

@section('content')
<div style="position:relative" class="text-center">
<h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">회원가입 (Sign up)</h1>
    <img src="/images/index/register.jpg" alt="">
</div>
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-sm-8 col-sm-offset-2">
            @if(Session::get('registration_success'))
                <div class="alert alert-success alert-dismissible" role="alert" style='font-size:18px;'>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>등록완료!</strong><br> 등록되었습니다. 관리자 승인 후 사용 가능합니다.
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <p>
                    
                    <div class="form-group @error('username') has-error @enderror">
                        <div for="">Username/ID *</div>
                        <input type="text" value="{{ old('username') }}" name="username" required  class="form-control ">
                        @error('username')
                           <span class="help-block">{{ $message }}</span>
                        @enderror 
                    </div>
                </p>
                <p>
                     <div class="form-group @error('password') has-error @enderror">
                        <div for="">Password *</div>
                        <input type="password" value="{{ old('password') }}" name="password" required class="form-control ">
                        @error('password')
                           <span class="help-block">{{ $message }}</span>
                        @enderror 
                     </div>
                </p>
                <p>
                    <div class="form-group @error('password') has-error @enderror">
                        <div for="">Repeat Password *</div>
                        <input type="password" value="{{ old('password') }}" name="password_confirmation" required  class="form-control ">
                    </div>
                </p>
                <p>
                    <div class="form-group @error('name') has-error @enderror">
                        <div for="">Name *</div>
                        <input type="text" name="name" value="{{ old('name') }}" required  class="form-control">
                        @error('name')
                           <span class="help-block">{{ $message }}</span>
                        @enderror 
                    </div>
                </p>
                <p>
                        <div for="">Grade</div>
                        <select name="grade" id="" class="form-control">
                                <option value="kinder" @if(old('grade') == 'kinder') selected @endif>Kinder</option>
                                <option value="1" @if(old('grade') == 1) selected @endif>Grade 1</option>
                                <option value="2" @if(old('grade') == 2) selected @endif>Grade 2</option>
                                <option value="3" @if(old('grade') == 3) selected @endif>Grade 3</option>
                                <option value="4" @if(old('grade') == 4) selected @endif>Grade 4</option>
                                <option value="5" @if(old('grade') == 5) selected @endif>Grade 5</option>
                                <option value="6" @if(old('grade') == 6) selected @endif>Grade 6</option>
                                <option value="7" @if(old('grade') == 7) selected @endif>Grade 7 Middle</option>
                                <option value="8" @if(old('grade') == 8) selected @endif>Grade 8 Middle</option>
                                <option value="9" @if(old('grade') == 9) selected @endif>Grade 9 Middle</option>
                        </select>
                </p>
                <p>
                        <div for="">Gender</div>
                        <select name="gender" id="" class="form-control">
                                <option value="male">Male</option>
                                <option value="female" @if(old('gender') == "male") selected @endif>Female</option>
                        </select>
                </p>
                <p>
                    <div class="form-group @error('email') has-error @enderror">
                        <div for="">Email</div>
                        <input type="email" name="email" value="{{ old('email') }}"  class="form-control">
                        @error('email')
                           <span class="help-block">{{ $message }}</span>
                        @enderror 
                    </div>
                </p>
                <p>
                        <div for="">Student Contact Number</div>
                        <input type="text" name="contact_number" value="{{ old('contact_number') }}"  class="form-control">
                </p>
                <p>
                        <div for="">Parent Contact Number</div>
                        <input type="text" name="parent_contact_number" value="{{ old('parent_contact_number') }}"  class="form-control">
                </p>
                <p>
                        <div for="">School Name</div>
                        <input type="text" name="school_name" value="{{ old('school_name') }}" class="form-control">
                </p>
                <p>
                    <button class="btn btn-primary btn-lg mt-3"><i class="fa fa-save"></i> Register</button>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
