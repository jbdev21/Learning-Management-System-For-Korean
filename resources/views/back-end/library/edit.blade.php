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
                    <form action="{{ route('back-end.library.update', $library->id) }}" method="POST">
                        @csrf
                        @method("PUT")
                        <p>
                            <label for="">Book</label>
                            <input type="text" readonly value="{{ $library->book->title }}" class="form-control">
                        </p>
                        <p>
                            <label for="">Student</label>
                            <input type="text" readonly value="{{ $library->user->name }}" class="form-control">
                        </p>
                        <p>
                            <label for="">Date Borrowed</label>
                            <input type="date" name="date_borrowed" value="{{ $library->date_borrowed }}" class="form-control">
                        </p>
                        <p>
                            <label for="">Date Return</label>
                            <input type="date" name="date_returned" value="{{ $library->date_returned ?? date('Y-m-d') }}" class="form-control">
                        </p>
                        <div class="text-right">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ route('back-end.library.index') }}" class="btn btn-default"><i class="fa fa-ban"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
            

        </div>
      </div>
@endsection