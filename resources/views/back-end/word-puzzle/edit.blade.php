@extends("back-end.includes.layouts.main")  
  

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Word Puzzle</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.word-puzzle.update', $puzzle->id)}}" method="POST" >  
                                @csrf
                                @method('PUT')
                                <p>
                                    <label for="">Puzzle Name</label>
                                    <input type="text" name='name' value="{{ $puzzle->name }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="published">Publish</option>
                                        <option value="draft" @if($puzzle->status == "draft") selected @endif >Draft</option>
                                    </select>
                                </p>
                                <p>
                                        <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save Changes</button>
                                        <a href="{{ route('back-end.word-puzzle.index') }}" class="btn btn-default btn-md rounded-0"><i class="fa fa-ban"></i> Back</a>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
            </div>
           
        </div>
      </div>
@endsection