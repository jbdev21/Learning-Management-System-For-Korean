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
              <li><a href="{{ route('back-end.student.edit', $student->id) }}" class="disabled">Basic Information</a></li>
              <li ><a href="{{ route('back-end.student.edit.step2', $student->id) }}" class="disabled">Assessment</a></li>
              <li class="active"><a href="{{ route('back-end.student.edit.step2', $student->id) }}">English Background</a></li>
              {{-- <li><a href="#" class="disabled">Class Room</a></li> --}}
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" >
                        @include('back-end.includes.alerts.success')
                        <form action="{{ route('back-end.student.edit.step3.update', $student->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="pull-right">
                                        <button class="btn btn-warning"><i class="fa fa-save"></i>  Save Changes</button>
                                </div>
                                <br>
                                <br>
                                <div class="clearfix"></div>
                                <div class="row">
                                        <div class="col-sm-6">
                                                <p>
                                                        <label for="">Address</label>
                                                        <input type="text" name="address" value="{{ optional($student->english_background)->address ?? '' }}" class="form-control">
                                                </p>
                                                <br>
                                                <p>
                                                        <label for=""  style="margin-top:10px;">Learning Experience</label>
                                                        <div class="row" style="margin-top:0px;">
                                                                <div class="col-sm-6" style='margin-top:0px; padding-top:0px;'>
                                                                        Years
                                                                        <input type="text" name="years_of_learning" value="{{ optional($student->english_background)->years_of_learning ?? '' }}" style="margin-top:8px;" class="form-control"  aria-describedby="basic-addon2">
                                                                </div>
                                                                <div class="col-sm-6" style='margin-top:0px; padding-top:0px;'>
                                                                        Experience Abroad?  &nbsp;&nbsp;
                                                                        <input type="radio" id="Yes" checked name="experience_abroad" 
                                                                                        @if(optional($student->english_background)->experience_abroad == "Yes") checked  @endif 
                                                                        value="Yes">
                                                                        <label for="Yes">Yes</label> &nbsp;&nbsp;
                                                                        <input type="radio" name="experience_abroad" @if(optional($student->english_background)->experience_abroad == "No") checked @endif value="No">
                                                                        <label for="No">No</label>
                                                                        <div>
                                                                                <input type="text" name="country" placeholder=" What country?" value="{{ optional($student->english_background)->country }}" class="form-control" style="display:inline-block">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </p>
                                                <br>
                                                <p>
                                                        <label for=""  style="margin-top:10px;">Subjects</label>
                                                        @foreach($subjects as $subject)
                                                                <div>
                                                                        <input type="checkbox" name="subjects[]" @if(in_array($subject->id, $student->subjectsEnglishBackground())) checked @endif id="{{ $subject->id }}" value="{{ $subject->id }}"> 
                                                                        <label style="font-weight: normal" for="{{ $subject->id }}">{{ $subject->abbreviation }} ( {{ $subject->name }} )</label>
                                                                </div>
                                                        @endforeach
                                                </p>
                                        </div>
                                        <div class="col-sm-6">
                                                <br>
                                                <p>
                                                        <label for="">Course Level</label>
                                                        <div class="row">
                                                                <div class="col-sm-6">
                                                                        ESSAY<br>
                                                                        <input type="radio" name="aws_level" id="asw_Prep" @if(optional($student->english_background)->aws_level == "Prep") checked @endif  value="Prep"> 
                                                                        <label style='font-weight:normal' for="asw_Prep">Prep</label> &nbsp;&nbsp;

                                                                        <input type="radio" name="aws_level" id="asw_Basic" @if(optional($student->english_background)->aws_level == "Basic") checked @endif   value="Basic"> 
                                                                        <label style='font-weight:normal' for="asw_Basic">Basic</label> &nbsp;&nbsp;

                                                                        <input type="radio" name="aws_level" id="asw_Intermediate" @if(optional($student->english_background)->aws_level == "Intermediate") checked @endif   value="Intermediate"> 
                                                                        <label style='font-weight:normal' for="asw_Intermediate">Intermediate</label> &nbsp;&nbsp;

                                                                        <input type="radio" name="aws_level" id="asw_Advanced" @if(optional($student->english_background)->aws_level == "Advanced") checked @endif   value="Advanced"> 
                                                                        <label style='font-weight:normal' for="asw_Advanced">Advanced</label> &nbsp;&nbsp;
                                                                        <br>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                        READ  (0.3 ~ 8.0)<br>
                                                                        <input type="number" step="0.1" min="0.3" max="8.0" name="erp_level" value="{{ optional($student->english_background)->erp_level ?? '' }}" class="form-control">  
                                                                        <br>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                        RG <br>
                                                                        <input type="radio" name="grr_level" id="grr_Prep" @if(optional($student->english_background)->grr_level == "Prelim") checked @endif   value="Prelim"> 
                                                                        <label style='font-weight:normal' for="grr_Prep">Prelim</label> &nbsp;&nbsp;

                                                                        <input type="radio" name="grr_level" id="grr_Basic" @if(optional($student->english_background)->grr_level == "Basic") checked @endif   value="Basic"> 
                                                                        <label style='font-weight:normal' for="grr_Basic">Basic</label> &nbsp;&nbsp;

                                                                        <input type="radio" name="grr_level" id="grr_Intermediate" @if(optional($student->english_background)->grr_level == "Intermediate") checked @endif   value="Intermediate"> 
                                                                        <label style='font-weight:normal' for="grr_Intermediate">Intermediate</label> &nbsp;&nbsp;

                                                                        <input type="radio" name="grr_level" id="grr_Advanced" @if(optional($student->english_background)->grr_level == "Advanced") checked @endif   value="Advanced"> 
                                                                        <label style='font-weight:normal' for="grr_Advanced">Advanced</label> &nbsp;&nbsp;
                                                                </div>
                                                                <div class="col-sm-6">
                                                                        
                                                                        <div class="row">
                                                                                <div class="col-sm-6">
                                                                                        PH Stage<br>
                                                                                        <input type="text" name="ph_stage" value="{{ optional($student->english_background)->ph_stage ?? '' }}" class="form-control">  
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                        PH (clinic)<br>
                                                                                        <input type="text" name="ph_clinic" value="{{ optional($student->english_background)->ph_clinic ?? '' }}" class="form-control">  
                                                                                </div>
                                                                        </div>
                                                                        <br>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                        ESL-C Beginner<br>
                                                                        <input type="text" name="dbc_speaking" value="{{ optional($student->english_background)->dbc_speaking ?? '' }}" class="form-control">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                        ESL-C Intermediate <br>
                                                                        <input type="text" name="dbc_debating" value="{{ optional($student->english_background)->dbc_debating ?? '' }}" class="form-control">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                        ESL-C Advanced <br>
                                                                        <input type="text" name="dbc_free_talking" value="{{ optional($student->english_background)->dbc_free_talking ?? '' }}" class="form-control">
                                                                </div>
                                                        </div>
                                                </p>
                                                <p>
                                                        <label for="">Class Count</label> <small><i>Times / week</i></small>
                                                        <input type="text" name="class_count" value="{{ optional($student->english_background)->class_count ?? '' }}" class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">Class Type</label> <br>
                                                        <input style="font-weight:normal;" type="radio" name="class_type"  @if(optional($student->english_background)->class_type == "1:1") checked @endif   value="1:1" id="1-1"> <label for="1-1">1:1</label> &nbsp;&nbsp;&nbsp;
                                                        <input style="font-weight:normal;" type="radio" name="class_type"  @if(optional($student->english_background)->class_type == "group") checked @endif  value="group" id="group"> <label for="group">Group</label> 
                                                </p>
                                                <p>
                                                        <label for="">Class Time</label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "ASW (100 minutes)") checked @endif  value="ASW (100 minutes)" id="asw100"> <label style="font-weight:normal;"  for="asw100">PH (50min.)</label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "ASW (120 minutes)") checked @endif  value="ASW (120 minutes)" id="asw120"> <label style="font-weight:normal;"  for="asw120">RE-B/I (60min.)</label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "ERP (60 minutes)") checked @endif  value="ERP (60 minutes)" id="erp60"> <label style="font-weight:normal;"  for="erp60">RE-B/I (90min.)</label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "ERP (80 minutes)") checked @endif  value="ERP (80 minutes)" id="erp80"> <label style="font-weight:normal;"  for="erp80">RE-A (120min.)</label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "ERP (90 minutes)") checked @endif  value="ERP (90 minutes)" id="erp90"> <label style="font-weight:normal;"  for="erp90">RG (90+90min./2+1T)</label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "GRR (60 minutes)") checked @endif  value="GRR (60 minutes)" id="grr60"> <label style="font-weight:normal;"  for="grr60">RG (100+90min./1+2T)</label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "PH (50 minutes)") checked @endif  value="PH (50 minutes)" id="asw50"> <label style="font-weight:normal;"  for="asw50">ESL-C (50min./1T) </label> <br>
                                                        <input type="radio" name="class_time" @if(optional($student->english_background)->class_time == "DBC (50 minutes)") checked @endif  value="DBC (50 minutes)" id="dbc50"> <label style="font-weight:normal;"  for="dbc50">ESL-C (50min./2T)</label> 
                                                </p>
                                        
                                        
                                        
                                        </div>
                                </div>
                        </form>
              </div>
            </div>
        </div>
@endsection
