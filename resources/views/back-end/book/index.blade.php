@extends("back-end.includes.layouts.main")  
@section('page-title', 'Books')
@section('content-header')
    <h1>
        Books
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="active">Book</li>
    </ol>
@endsection

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Books</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('back-end.book.store') }}" id="upload-excel-form" class="hidden" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" id="excel" name="excelfile">
            </form>
            <div class="row">
                <div class="col-sm-12">
                   
                    <div class='p-4'>
                        <form>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="input-group mb-2">
                                        <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" style="border-top-right-radius: 0px !important;border-bottom-right-radius: 0px !important;" placeholder="Search for...">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default" type="button">Search</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                                <div class="col-lg-9">
                                    <div class="text-right">
                                        <a href="{{ route('back-end.book.create') }}" class="btn mb-1 btn-warning"><i class="fa fa-plus"></i> Add New</a>
                                        <label class="btn mb-1 btn-warning" for="excel"><i class="fa fa-upload"></i> Upload Book</label>
                                        <a class="btn mb-1 btn-warning" href="{{ route('back-end.book.export') }}"><i class="fa fa-download"></i> Download Books</a>
                                        <a class="btn mb-1 btn-warning" href="/downloadables/book-import-format.xls"><i class="fa fa-file-excel-o"></i> Download Format</a>
                                        <a href="#" class="btn mb-1 btn-danger" id='delete-all-btn'><i class="fa fa-trash"></i> Delete Checked</a>
                                    </div>
                                </div><!-- /.col-lg-6 -->
                            </div><!-- /.row -->
                        </form>
                        <form action="{{ route('back-end.book.destroy', 0) }}" id="delete-all-form" method="POST">
                            <div class="table-responsive">   
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                            {{-- <input type="checkbox" id="checkAll" > --}}
                                            </th>
                                            <th></th>
                                            <th>No</th>
                                            <th>Series/Stage</th>
                                            <th>Series Name/Stage Name</th>
                                            <th>Title</th>
                                            <th>AR Level</th>
                                            <th>Availability</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($books as $book)
                                            <tr id="book-{{ $book->did }}">
                                                <td><input type="checkbox" name="item_checked[]" value="{{ $book->id }}"></td>
                                                <td><img src="{{ $book->thumbnail }}" style="height: 50px; width:30px;" alt=""></td>
                                                <td>{{ $book->book_number }}</td>
                                                <td>{{ $book->type }}</td>
                                                <td>{{ $book->type_name }}</td>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ $book->ar_level }}</td>
                                                <td>{!! $book->is_available ? '<i class="fa fa-circle text-success"></i>' : '<i class="fa fa-circle text-danger"></i>' !!}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle tex-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <i class="fa fa-gear"></i>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li><a href="{{ route('back-end.book.edit', $book->id) }}" ><i class="fa fa-pencil"></i> Edit</a></li>
                                                            <li><a class="delete-item" data-remove="#book-{{ $book->did }}" data-uri="{{  route('back-end.book.destroy', $book->id) }}"><i class="fa fa-trash"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class='text-center'> no books found </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $books->appends([
                                'q' => Request::get('q')
                            ])->links() }}
                            @csrf @method('DELETE')
                            {{-- {!! $html->table() !!} --}}
                        </form>
                    </div>
                </div>
            </div>
            

        </div>
      </div>
@endsection

{{-- @push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
    {!! $html->scripts() !!}
@endpush --}}