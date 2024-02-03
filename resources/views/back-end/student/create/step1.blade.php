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
        <form action="{{ route('back-end.student.store') }}" method="POST" style="display:none" enctype="multipart/form-data" id="import-form">
                @csrf
                <input type="file" name="excelfile" id="excelfile">
        </form>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#">Basic Information</a></li>
              <li><a href="{{ route('back-end.student.create.step2') }}">Assessment</a></li>
              <li><a href="{{ route('back-end.student.create.step3') }}">English Background</a></li>
              {{-- <li><a href="#" class="disabled">Class Room</a></li> --}}
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" >
                <form action="{{ route('back-end.student.store') }}" method="POST">
                @csrf
                <div class="pull-right">
                        {{-- <label for='excelfile' class="btn btn-warning"><i class="fa fa-file-excel-o"></i>  Import Excel</label> --}}
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
                                                <option value="{{ $branch->id }}">{{ $branch->center_name }}</option>
                                                @endforeach
                                        </select>
                                        </p>
                                @endif
                                <p>
                                        <label for="">Username/ID *</label>
                                        <input type="text" value="{{ old('username') }}" name="username" required class="form-control">
                                </p>
                                <p>
                                        <label for="">Password *</label>
                                        <input type="password" value="{{ old('password') }}" name="password" required class="form-control">
                                </p>
                                <p>
                                        <label for="">Name *</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required class="form-control">
                                </p>
                                <p>
                                        <label for="">Gender *</label>
                                        <select name="gender" id="" class="form-control">
                                                <option value="male">Male</option>
                                                <option value="female" @if(old('gender') == "male") selected @endif>Female</option>
                                        </select>
                                </p>
                                 <p>
                                        <label for="">Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}"  class="form-control">
                                </p>
                                <p>
                                        <label for="">Student Contact Number</label>
                                        <input type="text" name="contact_number" value="{{ old('contact_number') }}"  class="form-control">
                                </p>
                                <p>
                                        <label for="">Parent Contact Number</label>
                                        <input type="text" name="parent_contact_number" value="{{ old('parent_contact_number') }}"  class="form-control">
                                </p>
                                <p>
                                        <label for="">School Name</label>
                                        <input type="text" name="school_name" value="{{ old('school_name') }}" class="form-control">
                                </p>
                        </div>
                        <div class="col-sm-6">
                               
                                <p>
                                        <label for="">Status</label>
                                        <select name="status" id="" class="form-control">
                                        <option value="waiting">waiting</option>
                                        <option value="on-going" @if(old('status') == "on-going") selected @endif>on-going</option>
                                        <option value="on-leave" @if(old('status') == "on-leave") selected @endif>on-leave</option>
                                        </select>
                                </p>
                                <p>
                                        <label for="">Grade</label>
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
                                        <label for="">AR Level</label>
                                        <input type="text" name="ar_level" class="form-control" value="{{ old('ar_level') }}" >
                                </p>
                                
                                <p>
                                        <label for="">Remarks</label>
                                        <textarea name="remarks" id="" cols="30" rows="10" class="form-control">{{ old('remarks') }}</textarea>
                                </p>
                            
                        </div>
                 </div>
                </form>
              
              </div>
            </div>
        </div>
@endsection

@push('scripts')
        <script>
                $(document).ready(function(){
                        $('#excelfile').change(function(){
                                $('#import-form').submit();
                        })
                })
        </script>
@endpush
