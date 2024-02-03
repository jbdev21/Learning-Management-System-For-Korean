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
            <li><a href="{{ route('back-end.student.edit', $student->id) }}" class="disabled">Basic Information</a></li>
            <li class="active"><a href="#">Assessment</a></li>
            <li><a href="{{ route('back-end.student.edit.step3', $student->id) }}" class="disabled">English Background</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" >
                <div class="row">
                    <div class="col-sm-6">
                        @include('back-end.includes.alerts.success')
                        <form action="{{ route('back-end.student.edit.step2.update', $student->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="pull-right">
                                <button class="btn btn-warning"><i class="fa fa-save"></i>  Save</button>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="clearfix"></div>
                            @foreach($subjects as $subject)
                                <div class="input-group">
                                    <a href="#" class="input-group-addon" style='min-width:80px'  id="basic-addon2">{{ $subject->abbreviation }}</a>
                                    <input type="text" style="border-top-left-radius: 0px !important; border-bottom-left-radius: 0px !important" name="{{ $subject->abbreviation }}_score" value="{{ $student->assessment($subject->abbreviation . '_score') }}" placeholder="{{ $subject->abbreviation }} assessment result" class="form-control"  aria-describedby="basic-addon2">
                                </div>   
                                <br>
                            @endforeach
                            <p>
                                <label  style="margin-bottom: 0px;" for="">Book Series</label>
                               <select class="form-control select2" name="series[]" multiple>
                                    @foreach($book_series as $book_serie)
                                        <option @if(in_array(trim($book_serie), $student->studentData->book_access ?? [])) selected @endif value="{{ trim($book_serie) }}">{{ $book_serie }}</option>
                                    @endforeach
                                </select>
                            </p>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
