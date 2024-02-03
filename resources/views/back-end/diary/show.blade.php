@extends("back-end.includes.layouts.main")  

@section('page-title', $pagetitle)

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Diary Entry & Journal</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-2">
                    <a class="btn btn-warning" href="{{ route('back-end.diary.index') }}"><i class="fa fa-ban"></i> Back</a>
                    {{-- <div class="text-center">
                        <img src="/uploads/avatar/5e864d0ae90f11585859850.jpg" class="img img-circle" alt="">
                        <h3>{{ $student->name }}</h3>
                    </div> --}}
                </div>
                <div class="col-sm-8">
                    @foreach($diaries as $diary)
                        <h2 style="margin:0px;">{{ $diary->title }}</h2>
                        <div>
                            <i class="fa fa-calendar"></i> {{ $diary->date }}
                        </div>
                        <br>
                        {!! $diary->message  !!}
                        <br>
                        <d class="p-5">
                            <comment-component item="{{ $diary->id }}" model="diary"></comment-component>
                        </d>
                    @endforeach
                    <br>
                    <div class="arrows row">
                        <div class="col-sm-6">
                            <a href="{{  $previous ? route('back-end.diary.show', $previous->id) : '' }}" class="btn btn-default btn-lg btn-block {{ $previous ? '': 'disabled' }}"><i class="fa fa-chevron-circle-left"></i> Prev</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{  $next ? route('back-end.diary.show', $next->id) : '' }}" class="btn btn-default btn-lg btn-block {{ $next ? '': 'disabled' }}" class="btn btn-default btn-lg btn-block">Next <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>

                </div>
                <div class="col-sm-3">
                </div>
            </div>
           
        </div>
      </div>
@endsection

