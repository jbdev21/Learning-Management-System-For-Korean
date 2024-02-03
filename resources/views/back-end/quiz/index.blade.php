@extends("back-end.includes.layouts.main")

@section('page-title', 'Quizzes')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Quiz</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Create new Quiz</div>
                        <div class="panel-body">
                            <form action="{{ route('back-end.quiz.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <p>
                                    <label for="">Thumbnail</label>
                                    <input type="file" name="thumbnail">
                                </p>
                                <p>
                                    <label for="">Name</label>
                                    <input type="text" value="{{ old('name') }}" name="name" class="form-control">
                                </p>
                                <p>
                                    <label for="">Description</label>
                                    <textarea class="form-control" name="details">{{ old('details') }}</textarea>
                                </p>
                                <p>
                                    <label for="">Minutes Duration</label>
                                    <input type="number" required value="{{ old('duration') }}" name="duration" min="1" class="form-control">
                                </p>
                                <p>
                                    <label for="">Category</label>
                                    <select required name="category" class="form-control">
                                        <option value="Basic">Basic</option>
                                        <option @if(old('category') == "Advance") selected @endif value="Advance">Advance</option>
                                        <option @if(old('category') == "Intermediate") selected @endif  value="Intermediate">Intermediate</option>
                                    </select>
                                </p>
                                <br>
                                <p>
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    @forelse($quizzes as $quiz)
                         <div class="attachment-block clearfix" id="row-{{ $quiz->id }}">
                            <a href="{{ route('back-end.quiz.show', $quiz->id) }}">
                                <img class="attachment-img" src="{{ $quiz->getThumbnail() }}" alt="Attachment Image">
                            </a>
                            <div class="attachment-pushed">
                                <h4 class="attachment-heading"><a href="{{ route('back-end.quiz.show', $quiz->id) }}">{{ $quiz->name }}</a></h4>
                                <div class="attachment-text">
                                    <div>Questions: {{ $quiz->questions->count() }} </div>
                                    <div>Category: {{ $quiz->category }}</div>
                                    {{ nl2br((Str::limit($quiz->details, 150))) }}
                                    <div>
                                    <a class="btn btn-xs" href="{{ route('back-end.quiz.edit', $quiz->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                                    <a  class="btn btn-xs delete-item" data-uri="{{ route('back-end.quiz.destroy', $quiz->id) }}" data-remove="#row-{{ $quiz->id }}" ><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
      </div>
@endsection
