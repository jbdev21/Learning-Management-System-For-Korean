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
      <div class="box">
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
                            @foreach($classrooms as $room)
                                <div style="margin-top: 0px; margin-left:20px;">
                                    <input id="room-{{ $room->id }}" type="checkbox" name="classrooms[]" value="{{ $room->id }}">
                                    <label for="room-{{ $room->id }}">{{ $room->name }}</label>
                                </div>
                            @endforeach
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
      </div>
@endsection
