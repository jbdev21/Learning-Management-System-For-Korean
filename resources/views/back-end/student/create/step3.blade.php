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
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li><a href="{{ Request::get('student ')  ? route('back-end.student.edit', Request::get('student'))  : route('back-end.student.create') }}" >Basic Information</a></li>
                <li ><a href="{{ Request::get('student ')  ? route('back-end.student.edit.step2', Request::get('student'))  : route('back-end.student.create.step2') }}" >Assessment</a></li>
                <li class="active"><a href="#">English Background</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" >
                @if(Request::get('student'))
                        <form action="{{ route('back-end.student.create.step3.store', $student->id) }}" method="POST">
                        @csrf
                @endif
                                @if(Request::get('student'))
                                <div class="pull-right">
                                        <button class="btn btn-warning"><i class="fa fa-save"></i>  Save and Proceed</button>
                                </div>
                                <div class="clearfix"></div>
                                <br>
                                <br>
                                <br>
                        @else
                                <div class="alert alert-danger">
                                        Please complete Basic Information step to proceed.
                                </div>
                        @endif
                <div class="row">
                        <div class="col-sm-6">
                                <br>
                                <br>
                                <div class="clearfix"></div>
                                <p>
                                        <label for="">Address</label>
                                        <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                                </p>
                                <br>
                                <p>
                                        <label for=""  style="margin-top:10px;">Learning Experience</label>
                                        <div class="row" style="margin-top:0px;">
                                                <div class="col-sm-6" style='margin-top:0px; padding-top:0px;'>
                                                        Years
                                                        <input type="text" name="years_of_learning" style="margin-top:8px;" class="form-control"  aria-describedby="basic-addon2">
                                                </div>
                                                <div class="col-sm-6" style='margin-top:0px; padding-top:0px;'>
                                                        Experience Abroad?  &nbsp;&nbsp;
                                                        <input type="radio" id="Yes" checked name="experience_abroad" value="Yes">
                                                        <label for="Yes">Yes</label> &nbsp;&nbsp;
                                                        <input type="radio" name="experience_abroad" value="No">
                                                        <label for="No">No</label>
                                                        <div>
                                                                <input type="text" name="country" placeholder=" What country?" value="{{ old('country') }}" class="form-control" style="display:inline-block">
                                                        </div>
                                                </div>
                                        </div>
                                </p>
                                <br>
                                <p>
                                        <label for=""  style="margin-top:10px;">Subjects</label>
                                        @foreach($subjects as $subject)
                                                <div>
                                                        <input type="checkbox" name="subjects[]" id="{{ $subject->id }}" value="{{ $subject->id }}"> 
                                                        <label style="font-weight: normal" for="{{ $subject->id }}">{{ $subject->abbreviation }} ( {{ $subject->name }} )</label>
                                                </div>
                                        @endforeach
                                </p>
                                {{-- <p>
                                        <label for=""  style="margin-top:10px;">Domestic Experience</label>
                                        
                                        <div class="row" style="margin-top:0px;">
                                                <div class="col-sm-6" style='margin-top:0px; padding-top:0px;'>
                                                        Years
                                                        <input type="text" name="years_of_learning" style="margin-top:8px;" class="form-control"  aria-describedby="basic-addon2">
                                                </div>
                                                <div class="col-sm-6" style='margin-top:0px; padding-top:0px;'>
                                                        Experience Abroad?  &nbsp;&nbsp;
                                                        <input type="radio" id="Yes" checked name="experience_abroad" value="Yes">
                                                        <label for="Yes">Yes</label> &nbsp;&nbsp;
                                                        <input type="radio" name="experience_abroad" value="No">
                                                        <label for="No">No</label>
                                                        <div>
                                                        <input type="text" name="country" placeholder=" What country?" value="{{ old('country') }}" class="form-control" style="display:inline-block">
                                                        </div>
                                                </div>
                                        </div>
                                </p>
                                <br> --}}
                        </div>
                        <div class="col-sm-6">
                                <p>
                                        <label for="">Course Level</label>
                                        <div class="row">
                                                <div class="col-sm-6">
                                                        ESSAY <br>
                                                        <input type="radio" name="aws_level" id="asw_Prep" value="Prep"> 
                                                        <label style='font-weight:normal' for="asw_Prep">Prep</label> &nbsp;&nbsp;

                                                        <input type="radio" name="aws_level" id="asw_Basic" value="Basic"> 
                                                        <label style='font-weight:normal' for="asw_Basic">Basic</label> &nbsp;&nbsp;

                                                        <input type="radio" name="aws_level" id="asw_Intermediate" value="Intermediate"> 
                                                        <label style='font-weight:normal' for="asw_Intermediate">Intermediate</label> &nbsp;&nbsp;

                                                        <input type="radio" name="aws_level" id="asw_Advanced" value="Advanced"> 
                                                        <label style='font-weight:normal' for="asw_Advanced">Advanced</label> &nbsp;&nbsp;
                                                        <br>
                                                </div>
                                                <div class="col-sm-6">
                                                        READ  (0.3 ~ 8.0)<br>
                                                        <input type="number" step="0.1" min="0.3" max="8.0" name="erp_level" class="form-control">  
                                                        <br>
                                                </div>
                                                <div class="col-sm-6">
                                                        RG  <br>
                                                        <input type="radio" name="grr_level" id="grr_Prep" value="Prelim"> 
                                                        <label style='font-weight:normal' for="grr_Prep">Prelim</label> &nbsp;&nbsp;

                                                        <input type="radio" name="grr_level" id="grr_Basic" value="Basic"> 
                                                        <label style='font-weight:normal' for="grr_Basic">Basic</label> &nbsp;&nbsp;

                                                        <input type="radio" name="grr_level" id="grr_Intermediate" value="Intermediate"> 
                                                        <label style='font-weight:normal' for="grr_Intermediate">Intermediate</label> &nbsp;&nbsp;

                                                        <input type="radio" name="grr_level" id="grr_Advanced" value="Advanced"> 
                                                        <label style='font-weight:normal' for="grr_Advanced">Advanced</label> &nbsp;&nbsp;
                                                </div>
                                                <div class="col-sm-6">
                                                        
                                                        <div class="row">
                                                                <div class="col-sm-6">
                                                                        PH Stage<br>
                                                                        <input type="text" name="ph_stage" class="form-control">  
                                                                </div>
                                                                <div class="col-sm-6">
                                                                        PH (clinic)<br>
                                                                        <input type="text" name="ph_clinic" class="form-control">  
                                                                </div>
                                                        </div>
                                                        <br>
                                                </div>
                                                <div class="col-sm-4">
                                                        ESL-C Beginner  <br>
                                                        <input type="text" name="dbc_speaking" value="{{ old('dbc_speaking') }}" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                        ESL-C Intermediate  <br>
                                                        <input type="text" name="dbc_debating " value="{{ old('dbc_debating ') }}" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                        ESL-C Advanced  <br>
                                                        <input type="text" name="dbc_free_talking " value="{{ old('dbc_free_talking ') }}" class="form-control">
                                                </div>
                                        </div>
                                </p>
                                <p>
                                        <label for="">Class Count</label> <small><i>Times / week</i></small>
                                        <input type="text" name="class_count" value="{{ old('class_count') }}" class="form-control">
                                </p>
                                <p>
                                        <label for="">Class Type</label> <br>
                                        <input style="font-weight:normal;" type="radio" name="class_type" value="1:1" id="1-1"> <label for="1-1">1:1</label> &nbsp;&nbsp;&nbsp;
                                        <input style="font-weight:normal;" type="radio" name="class_type" value="group" id="group"> <label for="group">Group</label> 
                                </p>
                                <p>
                                        <label for="">Class Time</label> <br>
                                        <input type="radio" name="class_time" value="ASW (100 minutes)" id="asw100"> <label style="font-weight:normal;"  for="asw100">PH (50min.)</label> <br>
                                        <input type="radio" name="class_time" value="ASW (120 minutes)" id="asw120"> <label style="font-weight:normal;"  for="asw120">RE-B/I (60min.)</label> <br>
                                        <input type="radio" name="class_time" value="ERP (60 minutes)" id="erp60"> <label style="font-weight:normal;"  for="erp60">RE-B/I (90min.)</label> <br>
                                        <input type="radio" name="class_time" value="ERP (80 minutes)" id="erp80"> <label style="font-weight:normal;"  for="erp80">RE-A (120min.)</label> <br>
                                        <input type="radio" name="class_time" value="ERP (90 minutes)" id="erp90"> <label style="font-weight:normal;"  for="erp80">RG (90+90min./2+1T)</label> <br>
                                        <input type="radio" name="class_time" value="GRR (60 minutes)" id="grr60"> <label style="font-weight:normal;"  for="erp80">RG (100+90min./1+2T)</label> <br>
                                        <input type="radio" name="class_time" value="PH (50 minutes) " id="asw50"> <label style="font-weight:normal;"  for="asw50">ESL-C (50min./1T)</label> <br>
                                        <input type="radio" name="class_time" value="DBC (50 minutes)" id="dbc50"> <label style="font-weight:normal;"  for="dbc50">ESL-C (50min./2T)</label> 
                                </p>
                        </div>
                </div>
                @if(Request::get('student'))    
                </form>
                @endif        
              </div>
            </div>
        </div>
@endsection
