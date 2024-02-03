@extends("back-end.includes.layouts.main")

@section('page-title', $quiz->name)

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Quiz</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('back-end.quiz.question.store') }}" method="POST" style="display:none" enctype="multipart/form-data" id="import-form">
                @csrf
                <input type="file" name="excelfile" id="excelfile">
                <input type="hidden" name="quiz" value="{{ $quiz->id }}">
            </form>
            <div class="text-right">
                <a for='excelfile' href="{{ url('downloadables/quiz_format_excel.xlsx') }}" class="btn btn-warning"><i class="fa fa-download"></i>  Download Excel Format</a>
                <label for='excelfile' class="btn btn-warning"><i class="fa fa-file-excel-o"></i>  Import Excel</label>
            </div>
            @csrf
            <h3>{{ $quiz->name }}</h3>
            <p>
                {{ $quiz->details }}
            </p>
            <br>


            <question-component quizid="{{ $quiz->id }}" route="{{ route('back-end.quiz.question.store') }}" token="{{ csrf_token() }}"></question-component>

            <div class="row">

                <div class="col-sm-12">
                @if(!count($questions))
                    <h4 class="text-center"> No question found</h4>
                @endif
                <div class="row">
                    <div class="col-sm-6 pt-3">
                        {{ $quiz->questions->count() }} questions |
                        {{ $quiz->multiple()->count() }} Multiple Choices |
                        {{ $quiz->subjective()->count() }} Subjectives
                    </div>
                    <div class="col-sm-6 text-right">
                        {{ $questions->links() }}
                    </div>
                </div>
                @foreach($questions as $question)
                    <div class="panel panel-default mb-2 question-item" id="question-{{ $question->id }}">
                        <div class="panel-body">
                            <small class='pull-right'>
                                <span class="controls">
                                    <a href="{{ route('back-end.quiz.question.edit', $question->id) }}" class="mr-2" >Edit</a>
                                    <a href="#"  data-uri="{{ route('back-end.quiz.question.destroy', $question->id) }}" class="delete-item" data-remove="#question-{{ $question->id }}">Delete</a>
                                </span>
                            </small>
                            <div style="padding-right:80px;">
                                @foreach($question->images()->where('type', 'image_start')->get() as $startImages)
                                    <img style="width:100px;" src="{{ asset($startImages->source)  }}" alt="" class="img img-responsive thumbnail">
                                @endforeach
                                {!!  $question->body !!}
                            </div>
                            <br>
                            {{-- <br> --}}
                            <i class="text-muted">
                                <small>{{ ucfirst($question->type) }}</small>
                                 @if($question->type == "subjective")
                                    <small>{{ $question->case_sensitive ? '[Case Sensitive]' : '' }}</small>
                                 @endif
                            </i>
                            @if($question->type == "subjective")
                                @if($question->options)
                                    <ul style="list-style-type:none;">
                                        @forelse($question->options as $option)
                                            <li><i class="fa fa-check text-success"></i> {{ $option  }}</li>
                                        @empty
                                            <h2>No option found</h2>
                                        @endforelse
                                    </ul>
                                @endif
                            @else
                                <ul type="1" style="list-style-type:none;">
                                    @if($question->options)
                                        @forelse($question->options as $index => $option)
                                            <li>
                                                @if($question->answer == $index)
                                                    <i class="fa fa-check text-success"></i>
                                                @else
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif
                                                {{ $option  }}
                                            </li>
                                        @empty
                                            <h2>No option found</h2>
                                        @endforelse
                                    @endif
                                </ul>
                            @endif

                            <form id="question-{{ $question->id }}" method="post" action="{{ route('back-end.quiz.question.destroy', $question->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>

                        </div>
                    </div>
                @endforeach
                {{  $questions->links() }}

                </div>
            </div>
        </div>
      </div>
@endsection
@push('scripts')
   <script>
        $(document).ready(function(){
            $('#excelfile').change(function(){
                $('#import-form').submit();
            });
        })
    </script>
@endpush

