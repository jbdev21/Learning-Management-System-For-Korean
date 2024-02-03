@extends("back-end.includes.layouts.main")
@section('page-title', 'Books')
@section('content-header')
    <h1>
       Grammars
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="active">Grammars</li>
    </ol>
@endsection

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Grammars</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12">

                    <div class='p-4'>
                        <form>
                            <div class="row">
                                <div class="col-lg-3">
                                    <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" placeholder="Search for username..">
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-3">
                                    {{-- <label for="">Quiz</label> --}}
                                    <select name="quiz" id="" class="form-control">
                                        <option value="">- all quiz -</option>
                                        @foreach($quizzes as $quiz)
                                            <option value="{{ $quiz->id }}" {{ Request::get('quiz') == $quiz->id ? 'selected' : '' }}>{{ $quiz->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-warning" type="submit"><i class="fa fa-sort"></i> Search</button>
                                    <a href="{{ route('back-end.examination.index') }}" class="btn btn-warning"><i class="fa fa-ban"></i> Clear</a>
                                </div>
                            </div><!-- /.row -->
                        </form>
                        <form action="{{ route('back-end.examination.destroy', 0) }}" id="delete-all-form" method="POST">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Student</th>
                                            <th>Quiz</th>
                                            <th>Score</th>
                                            <th>Date/Time</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($examinations as $examination)
                                            <tr>
                                                <td>
                                                    {{ $examination->user->username }}
                                                </td>
                                                <td>{{ $examination->user->name }}</td>
                                                <td>
                                                    {{-- <a href="{{  route('back-end.quiz.show', $examination->quiz_id) }}"> --}}
                                                        {{ $examination->quiz->name }}</td>
                                                    {{-- </a> --}}
                                                <td>{{ $examination->quizScore() }}</td>
                                                <td>{{ $examination->created_at->format('Y-m-d h:iA') }}</td>
                                                <td class="text-right">
                                                    <a href="{{ route('back-end.examination.show', $examination->id) }}" class="btn btn-warning"><i class="fa fa-list"></i> Show Result</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class='text-center'> no examinations found </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $examinations->appends([
                                'q' => Request::get('q')
                            ])->links() }}
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>


        </div>
      </div>
@endsection
