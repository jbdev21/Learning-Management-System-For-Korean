@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Edit Student')

@section('content-header')
    <h1>
        Student
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com/">Home</a></li>
        <li>Student</li>
        <li class="active">Edit </li>
    </ol>
@endsection

@section('content')
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="{{ route('back-end.student.edit', $student->id) }}">Basic Information</a></li>
              <li><a href="{{ route('back-end.student.edit.step2', $student->id) }}" class="disabled">Assessment</a></li>
              <li><a href="{{ route('back-end.student.edit.step3', $student->id) }}" class="disabled">English Background</a></li>
              {{-- <li><a href="#" class="disabled">Class Room</a></li> --}}
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" >
                @include('back-end.includes.alerts.success')
                        <form action="{{ route('back-end.student.update', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="pull-right">
                                        <button class="btn btn-warning"><i class="fa fa-save"></i>  Save</button>
                                </div>
                                <div class="clearfix"></div>
                                <br>
                                <div class="row">
                                        <div class="col-sm-6">
                                                @if(auth()->user()->type == "administrator")
                                                        <p>
                                                        <label for="">Branch</label>
                                                        <select name="branch_id" id="" class="form-control">
                                                                @foreach($branches as $branch)
                                                                <option value="{{ $branch->id }}" @if($student->branch_id == $branch->id) selected @endif >{{ $branch->center_name }}</option>
                                                                @endforeach
                                                        </select>
                                                        </p>
                                                @endif
                                                <p>
                                                        <label for="">Username/ID *</label>
                                                        <input type="text" value="{{ $student->username }}" name="username" required class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">Name *</label>
                                                        <input type="text" name="name" value="{{ $student->name }}" required class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">Gender *</label>
                                                        <select name="gender" id="" class="form-control">
                                                                <option value="male">Male</option>
                                                                <option value="female" @if( $student->gender == "female") selected @endif>Female</option>
                                                        </select>
                                                </p>
                                                <p>
                                                        <label for="">Email</label>
                                                        <input type="email" name="email" value="{{ $student->email }}" class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">Password <small><i>( consider change password if provided)</i></small></label>
                                                        <input type="password" name="password" class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">Student Contact Number</label>
                                                        <input type="text" name="contact_number" value="{{ $student->contact_number }}" class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">Parent Contact Number</label>
                                                        <input type="text" name="parent_contact_number" value="{{ optional($student->data)->parent_contact_number }}"  class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">School Name</label>
                                                        <input type="text" name="school_name" value="{{ optional($student->data)->school_name }}"  class="form-control">
                                                </p>
                                        </div>
                                        <div class="col-sm-6">
                                                <p>
                                                        <label for="">Status *</label>
                                                        <select name="status" id="" class="form-control">
                                                        <option value="waiting">waiting</option>
                                                        <option value="on-going" @if( $student->status == "on-going") selected @endif>on-going</option>
                                                        <option value="on-leave" @if( $student->status == "on-leave") selected @endif>on-leave</option>
                                                        </select>
                                                </p>
                                                <p>
                                                        <label for="">Grade</label>
                                                        <select name="grade" id="" class="form-control">
                                                                <option value="kinder" @if(old('grade') == 'kinder') selected @endif>Kinder</option>
                                                                <option value="1" @if(optional($student->data)->grade == 1) selected @endif>Grade 1</option>
                                                                <option value="2" @if(optional($student->data)->grade == 2) selected @endif>Grade 2</option>
                                                                <option value="3" @if(optional($student->data)->grade == 3) selected @endif>Grade 3</option>
                                                                <option value="4" @if(optional($student->data)->grade == 4) selected @endif>Grade 4</option>
                                                                <option value="5" @if(optional($student->data)->grade == 5) selected @endif>Grade 5</option>
                                                                <option value="6" @if(optional($student->data)->grade == 6) selected @endif>Grade 6</option>
                                                                <option value="7" @if(optional($student->data)->grade == 7) selected @endif>Grade 7 Middle</option>
                                                                <option value="8" @if(optional($student->data)->grade == 8) selected @endif>Grade 8 Middle</option>
                                                                <option value="9" @if(optional($student->data)->grade == 9) selected @endif>Grade 9 Middle</option>
                                                        </select>
                                                </p>
                                                <p>
                                                        <label for="">AR Level</label>
                                                        <input type="text" name="ar_level"  class="form-control" value="{{ optional($student->studentData)->ar_level }}" >
                                                </p>
                                                
                                                <p>
                                                        <label for="">Remarks</label>
                                                        <textarea name="remarks" id="" cols="30" rows="10" class="form-control">{{ optional($student->data)->remarks }}</textarea>
                                                </p>
                                        
                                
                                </div>
                                </div>
                        </form>
              </div>
            </div>
        </div>
@endsection
