@extends("back-end.includes.layouts.main")    
@section('page-title', 'Library')
@section('content-header')
    <h1>
        Library
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="active">Library</li>
    </ol>
@endsection

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">History</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">
                    <form action="{{ route('back-end.library.store') }}" method="POST">
                        @csrf
                        <p>
                            <label for="">Book</label>
                            <select name="book_id" class="form-control select2-book"></select>
                        </p>
                        <p>
                            <label for="">Student</label>
                            <select name="user_id" class="form-control select2-student"></select>
                        </p>
                        <p>
                            <label for="">Date Borrowed</label>
                            <input type="date" name="date_borrowed" value="{{ date('Y-m-d') }}" class="form-control">
                        </p>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-8">
                    <div class='p-4'>
                        <form>
                                <div class="row">
                                        <div class="col-sm-4">
                                                <input type="text" class="form-control" name="search" value="{{ Request::get('search') }}" placeholder="Search for...">              
                                        </div>
                                        <div class="col-sm-4">
                                                <select name="status" id="" class="form-control">
                                                        <option value="">- All -</option>
                                                        <option value="borrowed" @if(Request::get('status') == "borrowed") selected @endif >Borrowed</option>
                                                        <option value="returned" @if(Request::get('status') == "returned") selected @endif >Returned</option>
                                                </select>
                                        </div>
                                        <div class="col-sm-4">
                                                <button class="btn btn-warning" type='submit'> <i class="fa fa-sort"></i> Search</button>
                                                @if(Request::get('search') || Request::get('status'))
                                                 <a  href="{{ route('back-end.library.index') }}" class="btn btn-default" type='submit'> <i class="fa fa-ban"></i> Clear</a>
                                                @endif
                                        </div>
                                </div>
                        </form>
                        <br>
                       <table class="table">
                               <thead>
                                       <tr>
                                               <th>Book</th>
                                               <th>Student</th>
                                               <th>Date Borrowed</th>
                                               <th>Date Return</th>
                                               <th></th>
                                       </tr>
                               </thead>
                               <tbody>
                                       @forelse($histories as $history)
                                                <tr id="item-{{ $history->id }}">
                                                        <td>{{ $history->book->title }}</td>
                                                        <td>{{ $history->user->name }}</td>
                                                        <td>{{ $history->date_borrowed }}</td>
                                                        <td>@if($history->date_returned){{ $history->date_returned }} @else   @endif</td>
                                                        <td class="text-right">
                                                                <a class="btn btn-xs btn-default" href="{{ route('back-end.library.edit', $history->id) }}"><i class="fa fa-pencil"></i> Update</a>
                                                                <a class="btn btn-xs btn-default delete-item" data-remove="#item-{{ $history->id }}" data-uri="{{ route('back-end.library.destroy', $history->id) }}"><i class="fa fa-trash"></i> Delete</a>
                                                        </td>
                                                </tr>
                                        @empty
                                                <tr>
                                                        <td colspan="5" class="text-center text-muted"> No history @if(Request::get('search')) found @endif</td>
                                                </tr>
                                        @endforelse
                               </tbody>
                       </table>
                       {{ $histories->links() }}
                    </div>
                </div>
            </div>
            

        </div>
      </div>
@endsection