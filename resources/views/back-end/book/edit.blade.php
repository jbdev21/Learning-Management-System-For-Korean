@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Edit Book');

@section('content-header')
    <h1>
        Books
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="{{ route('back-end.book.index') }}">Book</li>
        <li class="active">Edit Book</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Books</h3>
            </div>

            <div class="box-body">
                <form action="{{ route('back-end.book.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <p>
                        <label for="">Title</label>
                        <input type="text" name="title" value="{{ $book->title }}" class="form-control">
                    </p>
                    <p>
                        <label for="">Book Number</label>
                        <input type="text" name="book_number" value="{{ $book->book_number }}" class="form-control">
                    </p>
                    <p>
                        <label for="">Book Type</label>
                        <select required name="type" class="form-control">
                            <option value="series">Series</option>
                            <option value="library"  @if($book->type == "library") selected @endif>Library</option>
                            <option value="stage" @if($book->type == "stage") selected @endif >Stage</option>
                        </select>
                    </p>
                    <p>
                        <label for="">Type Name</label>
                        <input type="text" name="type_name" value="{{ $book->type_name }}" class="form-control">
                    </p>
                    {{-- <p>
                        <label for="">Author</label>
                        <input type="text" name="author" value="{{ $book->author }}" class="form-control">
                    </p> --}}
                    <p>
                        <label for="">AR Level</label>
                        <input type="text" name="ar_level" value="{{ $book->ar_level }}" class="form-control">
                    </p>
                    <p>
                        <label for="">Thumbnail</label>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#tab_1" data-toggle="tab">Link</a></li>
                              <li><a href="#tab_2" data-toggle="tab">Image Upload</a></li>
                            </ul>
                            <div class="tab-content mt-4 pb-5">
                                <div class="tab-pane @if($thumbnail) @if($thumbnail->source_type == "link") active @endif @else active @endif" id="tab_1">
                                <input type="url" @if($thumbnail) @if($thumbnail->source_type == "link") value="{{ $thumbnail->source }}"  @endif @endif name="link" class="form-control" placeholder=" insert url">
                                </div>
                                <div class="tab-pane @if($thumbnail) @if($thumbnail->source_type == "local") active @endif @endif"   id="tab_2">
                                  <input type="file" name="thumbnail">
                                </div>
                            </div>
                        </div>

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

