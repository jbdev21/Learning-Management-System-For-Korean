@extends("student.includes.layouts.empty")  
@section('content')
        <div class="row">
            {{-- <div class="col-sm-2">
                <div class="with-shadow">
                    <img src="{{ $quiz->getThumbnail() }}" class="img-responsive" alt="">
                    <div class="p-sm bg-white">
                        <h3>{{ $quiz->name }}</h3>
                        <p>
                        {!! nl2br(Str::limit($quiz->details, 150)) !!}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-8"> --}}
                <question-component geturl="{{ route('student.quiz.question', $quiz->code) }}" sendanswerurl="{{ route('student.quiz.question.answer') }}"></question-component>
            </div>
            {{-- <div class="col-sm-2">
                <question-timer end="{{ $time }}"></question-timer>
                <form action="{{ route('student.quiz.stop', $quiz->code) }}" method='POST'>
                    @csrf
                    <button class="btn-block btn btn-default btn-lg" type="submit"><i class="fa fa-ban"></i>  Stop Quiz</button>
                </form>
            </div> --}}
        </div>
@endsection
