@extends("student.includes.layouts.main")  
@section('content')
<br>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <div class="box" style="margin:0px;">
                <audiorecorder-component storeroute="{{ route('student.recording.store') }}" backroute="{{ route('student.recording.index') }}"></audiorecorder-component>
            </div>
        </div>
    </div>
@endsection