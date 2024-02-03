@extends('layouts.website')

@section('content')
<div style="position:relative" class="text-center">
      <h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">LIBRARY</h1>
      <img src="/images/index/banners/library.jpg" alt="">
</div>
      <div class="container pt-2">
                 <form>
                        <div class="row">
                                <div class="col-lg-3">
                                        <div class="input-group">
                                        <input type="text" name="q" value="{{ Request::get('q') }}" class="form-control" style="border-top-right-radius: 0px !important;border-bottom-right-radius: 0px !important;" placeholder="Search for...">
                                        <span class="input-group-btn">
                                                <button type="submit" class="btn btn-primary" type="button">Search</button>
                                        </span>
                                        </div><!-- /input-group -->
                                </div><!-- /.col-lg-6 -->
                        </div><!-- /.row -->
                </form>
                <div class="row">
                        @forelse($books as $book)
                                <div class="col-sm-4">
                                        <div class="panel panel-default">
                                                <div class="panel-heading" 
                                                style="background-image:url({{ $book->thumbnail}}); background-size:cover; background-position:center; padding-top:75%" ></div>
                                                <div class="panel-heading">
                                                        <h3>{{ $book->title }}</h3>
                                                </div>
                                        </div>                
                                </div>
                        @endforeach
                </div>
                {{-- <table class="table">
                        <thead>
                                <tr>
                                        <th>No</th>
                                        <th>Series/Stage</th>
                                        <th>Series Name/Stage Name</th>
                                        <th>Title</th>
                                        <th>AR Level</th>
                                        <th>Availability</th>
                                </tr>
                        </thead>
                        <tbody>
                                @forelse($books as $book)
                                <tr>
                                     
                                        <td>{{ $book->book_number }}</td>
                                        <td>{{ $book->type }}</td>
                                        <td>{{ $book->type_name }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->ar_level }}</td>
                                        <td>{!! $book->is_available ? '<i class="fa fa-circle text-success"></i>' : '<i class="fa fa-circle text-danger"></i>' !!}</td>
                                </tr>
                                @empty
                                <tr>
                                        <td colspan=6 class='text-center'> no books found </td>
                                </tr>
                                @endforelse
                        </tbody>
                </table> --}}
        {{ $books->appends(['q' => Request::get('q')])->links() }}
           
      </div>
@endsection