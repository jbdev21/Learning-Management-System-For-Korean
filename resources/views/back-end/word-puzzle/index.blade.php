@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Word Puzzle')

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
                            <form action="{{ route('back-end.word-puzzle.store')}}" method="POST" >  
                                @csrf
                           
                                <p>
                                    <label for="">Puzzle Name</label>
                                    <input type="text" name='name' value="{{ old('name') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="published">Publish</option>
                                        <option value="draft">Draft</option>
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
                        <button class="btn btn-danger" id='delete-all-btn'><i class="fa fa-trash"></i> Delete</button>
                    </div>
                    <form action="{{ route('back-end.word-puzzle.destroy', 0) }}" method="POST" id="delete-all-form">
                        @method('DELETE') @csrf
                    
                        <table class="table">   
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Name</th>
                                    <th>Items</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($puzzles as $puzzle)
                                    <tr id="item-{{ $puzzle->id }}">
                                        <td><input type="checkbox" name="checkedItems[]" value="{{ $puzzle->id }}"></td>
                                        <td>{{ $puzzle->name }}</td>
                                        <td>{{ $puzzle->puzzleWords()->count() }}</td>
                                        <td>{{ ucfirst($puzzle->status) }}</td>
                                        <td class="text-right">
                                            <a class="btn btn-xs btn-primary" href="{{ route('back-end.word-puzzle.show', $puzzle->id) }}"><i class="fa fa-eye"></i> Manage</a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('back-end.word-puzzle.edit', $puzzle->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                                            <button type="button" class="btn btn-xs btn-danger delete-item" data-remove="#item-{{ $puzzle->id }}" data-uri="{{ route('back-end.word-puzzle.destroy', $puzzle->id) }}"><i class="fa fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{-- {!! $html->table() !!} --}}
                    </form>
                </div>
            </div>
           
        </div>
      </div>
@endsection