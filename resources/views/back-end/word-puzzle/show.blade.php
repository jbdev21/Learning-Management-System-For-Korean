@extends("back-end.includes.layouts.main")  

@section('page-title', $puzzle->name)

@section('content')
      <div class="box">
        <div class="box-header with-border">
                <a href="{{ route('back-end.word-puzzle.index') }}" class="btn btn-sm btn-warning mr-3"><i class="fa fa-ban"></i> Back</a>
          <h3 class="box-title">{{ $puzzle->name }}</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.puzzle-word.store')}}" method="POST" >  
                                @csrf
                                    <input type="hidden" name='word_puzzle_id' value="{{ $puzzle->id }}" class="form-control">
                                <p>
                                    <label for="">Clue</label>
                                    <input type="text" name='clue' value="{{ old('clue') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Answer</label>
                                    <input type="text" name='answer' value="{{ old('answer') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Orrientation</label>
                                    <select name="orrientation" id="" class="form-control">
                                        <option value="across">Across</option>
                                        <option value="down">Down</option>
                                    </select>
                                </p>
                                <p>
                                    <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-sm-8">
                        <div class="text-right">
                                @foreach($puzzle->puzzleWords()->get() as $puzzleword)
                                        <div class="alert border-1 text-left" style="border:1px solid #ccc">
                                                <p>{{ $puzzleword->clue }}</p>
                                                <p>Answer: <b>{{ $puzzleword->answer }}</b></p>
                                                <div class="mt-2">
                                                        <a href="#" style="text-decoration: none;" class="btn btn-default btn-xs text-black"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="#" style="text-decoration: none;" class="btn btn-default btn-xs text-black"><i class="fa fa-trash"></i> Trash</a>
                                                </div>
                                        </div>
                                @endforeach
                        </div>
                </div>
            </div>
           
        </div>
      </div>
@endsection