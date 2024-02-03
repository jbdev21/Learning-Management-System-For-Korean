@extends("student.includes.layouts.main")
@section('content')
<div class="container">
    <div class="page-heading">
        <div class="text">
            <i class="fa fa-question-circle"></i>
            Explore hundreds of teacher-created quizzes
        </div>
        <br>
        <form>
            <select required name="category" style="width:200px; display: inline-block" class="form-control">
                <option value="">- All Categories -</option>
                <option @if(Request::get('category') == "Basic") selected @endif value="Basic">Basic</option>
                <option @if(Request::get('category') == "Intermediate") selected @endif  value="Intermediate">Intermediate</option>
                <option @if(Request::get('category') == "Advance") selected @endif value="Advance">Advance</option>
            </select>
            <div class="input-group pull-right"  style="width:400px;">
                <input type="text" name="q" value="{{ request('q') }}"class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button type="submit" class="btn btn-default" type="button">Search</button>
                </span>
            </div>
        </form>
    </div>

    <div class="row">
        @forelse($quizzes as $quiz)
            <div class="col-sm-3">
                <div class="card">
                        <div class="card-img-top">
                            <div style="background-image:url({{ $quiz->getThumbnail() }}); padding-top:75%; background-size:cover; background-position:center"></div>
                            {{-- <img class=" img-responsive" src="" alt="Card image cap"> --}}
                            <div class="overlay-details">
                                <div>
                                    <span>
                                        {{ $quiz->questions_count }} Qs
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span>
                                        {{ $quiz->questions_count }} plays
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="min-height: 170px; position:relative">
                            <div class="card-title">{{ Str::limit($quiz->name, 40) }}</div>
                            <div style="margin-bottom:10px;">{{ $quiz->category }}</div>
                            <div style="position:absolute; bottom:0px; left:0; width:100%; padding:10px;">
                                @if($quiz->lastExamination)
                                <small>
                                    <a href="{{  route('student.quiz.result', $quiz->lastExamination->id) }}?q={{ Request::get('q') }}&category={{ Request::get('category') }}" >Score: {{  $quiz->lastExamination->quizScore()  }} </a>
                                    <span class="pull-right">{{  $quiz->lastExamination->created_at->format('m/d/Y')  }} </span>
                                    <a class="btn btn-primary btn-block" href="{{ route('student.quiz.show', $quiz->code) }}">Play Again</a>
                                </small>
                                @else
                                <a class="btn btn-primary btn-block" href="{{ route('student.quiz.show', $quiz->code) }}">Play</a>
                                @endif
                            </div>
                        </div>
                    {{-- </a> --}}
                </div>
            </div>
        @empty
            <h2 class="text-muted text-center"> No quiz found</h2>
        @endforelse

    </div>
    {{ $quizzes
        ->appends([
            'q' => request('q'),
            'category' => request('category')
        ])
        ->links() }}
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('select[name=category]').on('change', function(){
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
