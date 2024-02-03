@extends("student.includes.layouts.main")  
@section('content')
<div class="box  col-md-8 col-lg-8 col-md-push-2  col-lg-push-2">
    <div class="header-title">
        <h1>Diary Entry & Journal</h1>
        <div class="tag-line">
            영어 논술
        </div>
    </div>

    <div class="box-content">
        <diary-component></diary-component>
    </div>

</div>
@endsection
