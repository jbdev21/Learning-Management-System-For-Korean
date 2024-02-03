@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Create new Student')

@section('content-header')
    <h1>
        Student
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com/">Home</a></li>
        <li>Student</li>
        <li class="active">Create </li>
    </ol>
@endsection

@section('content')
      {{-- <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Student</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <form action="{{ route('back-end.student.store') }}" method="POST">
                        @csrf
             
                        <p>
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control">
                        </p>
                        <p>
                            <label for="">Grade</label>
                            <select class='form-control' name="grade" id="">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </p>
                        <p>
                            <label for="">Email Address</label>
                            <input type="text" name="email" class="form-control">
                        </p>
                        <p>
                            <label for="">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control">
                        </p>
                        <p>
                            <label for="">Parent Contact Number</label>
                            <input type="text" name="parent_contact_number" class="form-control">
                        </p>
                        <p>
                            <label  style="margin-bottom: 0px;" for="">Class Rooms</label>
                            <select class="form-control select2" name="classrooms[]" multiple>
                                @foreach($classrooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </p>

                        <p>
                            <label  style="margin-bottom: 0px;" for="">Book Series</label>
                            <select class="form-control select2" name="series[]" multiple>
                                @foreach($book_series as $book_serie)
                                    <option value="{{ $book_serie }}">{{ $book_serie }}</option>
                                @endforeach
                            </select>
                        </p>

                        <hr>
                        <p>
                            <label for="">Username</label>
                            <input type="text" name="username" required class="form-control">
                        </p>
                        <p>
                            <label for="">Password</label>
                            <input type="password" name="password" required class="form-control">
                            <input type="checkbox" id="defaultpassword"  name='default_password'> <label class='text-info' for="defaultpassword">Use Default Password: Password</label>
                        </p>
                        <p>
                            <button class="btn btn-warning" type="submit"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ route('back-end.student.index') }}" class="btn btn-default" ><i class="fa fa-ban"></i> Cancel</a>
                        </p>
                    </form>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
      </div> --}}

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li><a href="{{ Request::get('student ')  ? route('back-end.student.edit', Request::get('student'))  : route('back-end.student.create') }}">Basic Information</a></li>
              <li class="active"><a href="#">Assessment</a></li>
              <li><a href="{{ Request::get('student ')  ? route('back-end.student.edit.step3', Request::get('student'))  : route('back-end.student.create.step3') }}">English Background</a></li>
              {{-- <li><a href="#" class="disabled">Class Room</a></li> --}}
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" >
                 <div class="row">
                     <div class="col-sm-6">
                         @if(Request::get('student'))
                         <form action="{{ route('back-end.student.create.step2.store', $student->id) }}" method="POST">
                                @csrf
                         @endif
                                @if(Request::get('student'))
                                    <div class="pull-right">
                                            <button class="btn btn-warning"><i class="fa fa-save"></i>  Save and Proceed</button>
                                    </div>
                                      <br>
                                <br>
                                <br>
                                @else
                                    <div class="alert alert-danger">
                                        Please complete Basic Information step to proceed.
                                    </div>
                                @endif
                              
                                <div class="clearfix"></div>
                                @foreach($subjects as $subject)
                                        <div class="input-group">
                                                <a href="#" class="input-group-addon" style='min-width:80px'  id="basic-addon2">{{ $subject->abbreviation }}</a>
                                                <input type="text" style='border-radius:0px;' name="{{ $subject->abbreviation }}_score" placeholder="{{ $subject->abbreviation }} assessment result" class="form-control"  aria-describedby="basic-addon2">
                                        </div>   
                                        <br>
                                @endforeach
                                 <p>
                                        <label  style="margin-bottom: 0px;" for="">Book Series</label>
                                        <select class="form-control select2" name="series[]" multiple>
                                                @foreach($book_series as $book_serie)
                                                <option value="{{ $book_serie }}">{{ $book_serie }}</option>
                                                @endforeach
                                        </select>
                                </p>
                        @if(Request::get('student'))
                        </form>
                        @endif
                     </div>
                 </div>
              
              </div>
            </div>
        </div>
@endsection
