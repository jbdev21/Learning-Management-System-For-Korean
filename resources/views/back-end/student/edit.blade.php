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
                    <form action="{{ route('back-end.student.update', $student->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <p>
                            <label for="">Name</label>
                            <input type="text" required name="name" value="{{ $student->name }}" class="form-control">
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
                            <label for="">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ $student->contact_number }}"  class="form-control">
                        </p>
                        <p>
                            <label for="">Parent Contact Number</label>
                            <input type="text" name="parent_contact_number" value="{{ $student->parent_contact_number }}" class="form-control">
                        </p>
                        <p>
                            <label  style="margin-bottom: 0px;" for="">Class Rooms</label>
                            <select class="form-control select2" name="classrooms[]" multiple>
                                @foreach($classrooms as $room)
                                    <option @if(in_array($room->id, $studentsRooms ?? [])) selected  @endif value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </p>
                        <p>
                            <label  style="margin-bottom: 0px;" for="">Book Series</label>
                            <select class="form-control select2" name="series[]" multiple>
                                @foreach($book_series as $book_serie)
                                    <option @if(in_array($book_serie, $student->book_access ?? [])) selected @endif value="{{ $book_serie }}">{{ $book_serie }}</option>
                                @endforeach
                            </select>
                        </p>

                        <hr>
                        <p>
                            <label for="">Username</label>
                            <input type="text" required name="username" value="{{ $student->username }}"  class="form-control">
                        </p>
                        <p>
                            <label for="">Password</label> <small><i> * Consider change password</i></small> 
                            <input type="password" name="password" class="form-control">
                            <input type="checkbox" id="defaultpassword" name='default_password'> <label class='text-info' for="defaultpassword">Use Default Password: Password</label>
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
