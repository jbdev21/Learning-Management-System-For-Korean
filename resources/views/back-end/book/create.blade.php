@extends("back-end.includes.layouts.main")  
@section('page-title', 'Add New Book')
@section('content-header')
    <h1>
        Books
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="{{ route('back-end.book.index') }}">Book</li>
        <li class="active">Create</li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Books</h3>
        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-sm-6">
                    <form action="{{ route('back-end.book.store') }}" method="POST">
                        @csrf
                        <p>
                            <label for="">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                        </p>
                        <p>
                            <label for="">Book Number</label>
                            <input type="text" name="book_number" value="{{ old('book_number') }}" class="form-control">
                        </p>
                        <p>
                            <label for="">Book Type</label>
                            <select required name="type" class="form-control">
                                <option value="series">Series</option>
                                <option value="library" @if(old('type') == 'library') selected @endif>Library</option>
                                <option value="stage" @if(old('type') == 'stage') selected @endif>Stage</option>
                            </select>
                        </p>
                        <p>
                            <label for="">Type Name</label>
                            <input type="text" name="type_name" value="{{ old('type_name') }}" class="form-control">
                        </p>
                        {{-- <p>
                            <label for="">Author</label>
                            <input type="text" name="author" value="{{ old('author') }}" class="form-control">
                        </p> --}}
                        <p>
                            <label for="">AR Level</label>
                            <input type="text" name="ar_level"  value="{{ old('ar_level') }}" class="form-control">
                        </p>

                        <div class="text-right">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ route('back-end.book.index') }}"  class="btn btn-default"><i class="fa fa-ban"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

