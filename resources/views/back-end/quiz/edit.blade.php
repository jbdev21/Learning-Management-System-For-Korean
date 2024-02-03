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
                        <div class="panel-heading">Update Quiz</div>
                        <div class="panel-body">
                            <form action="{{ route('back-end.quiz.update', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <img src="{{ $quiz->getThumbnail() }}" class="img-responsive" alt="">
                                 <p>
                                    <label for="">Thumbnail</label>
                                    <input type="file" name="thumbnail" class="form-control">
                                </p>
                                <p>
                                    <label for="">Name</label>
                                    <input type="text" name="name" value="{{ $quiz->name }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Description</label>
                                    <textarea class="form-control" name="details">{!! $quiz->details !!}</textarea>
                                </p>
                                <p>
                                    <label for="">Minutes Duration</label>
                                    <input type="number" required name="duration"  value="{{ $quiz->duration }}" min="1" class="form-control">
                                </p>
                                <p>
                                    <label for="">Category</label>
                                    <select required name="category" class="form-control">
                                        <option value="">- select category -</option>
                                        <option @if($quiz->category == "Basic") selected @endif value="Basic">Basic</option>
                                        <option @if($quiz->category == "Advance") selected @endif value="Advance">Advance</option>
                                        <option @if($quiz->category == "Intermediate") selected @endif  value="Intermediate">Intermediate</option>
                                    </select>
                                </p>
                                <br>
                                <p>
                                    <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save Changes</button>
                                    <a href="{{ route('back-end.quiz.index') }}" class="btn btn-default"><i class="fa fa-ban"></i> Cancel</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
@endsection
