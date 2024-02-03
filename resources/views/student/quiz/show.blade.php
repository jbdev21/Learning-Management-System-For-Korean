@extends("student.includes.layouts.main")
@section('content')
<div class="container">
    <div class="box">

        <div class="row">
            <div class="col-sm-3">
                <img src="{{ $quiz->getThumbnail() }}" class="img-responsive" alt="">
            </div>
            <div class="col-sm-9">
                <h1>{{ $quiz->name }}</h1>

                <p>
                {!! nl2br($quiz->details) !!}
                </p>
                <div class="row">
                    <div class="col-sm-6 text-muted">
                        <br>
                        <span>
                        <i class="fa fa-clock-o"></i> {{ $quiz->duration }}min.
                        </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>
                        <i class="fa fa-question-circle-o"></i> {{ $quiz->questions->count()}} Qs
                        </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span>
                        <i class="fa fa-play-circle-o"></i> {{ $quiz->questions->count()}} Plays
                        </span>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('student.quiz.question', $quiz->code) }}" class="btn btn-warning btn-lg"><i class="fa fa-play"></i> Start Quiz</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
