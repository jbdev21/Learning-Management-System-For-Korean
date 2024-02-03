@extends("back-end.includes.layouts.main")  

@section('page-title', $quiz->name)

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <a href="{{ route('back-end.quiz.show', $question->quiz_id) }}" class="btn btn-warning"><i class="fa fa-backward"></i> Back</a>
        </div>
        <div class="box-body">
            <h3>{{ $quiz->name }}</h3>
            <p>
                {{ $quiz->details }}
            </p>
            <hr>
            <question-component-edit resourceroute="{{ route('back-end.quiz.question.edit', $question->id) }}" quizid="{{ $quiz->id }}" route="{{ route('back-end.quiz.question.update', $question->id) }}" token="{{ csrf_token() }}"></question-component-edit>    
        </div>
      </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.min.css" integrity="sha256-Qo9dfxjSvWBpcONv1klYEjbmw13NfsOC+oARxiq49/A=" crossorigin="anonymous" />
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-wysiwyg/0.3.3/bootstrap3-wysihtml5.all.min.js" integrity="sha256-/pAqJaOZhKjDz1Ld/tOpZp7vnIOaMkkA5aawwwr0zfk=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('.editor').wysihtml5()
    })
</script>
@endpush
