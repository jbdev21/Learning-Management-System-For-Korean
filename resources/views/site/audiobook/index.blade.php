@extends('layouts.website')

@section('content')
<div style="position:relative" class="text-center">
      <h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">Audio Book</h1>
      <img src="/images/index/banners/library.jpg" class="img img-responsive" alt="">
</div>
      <div class="container pt-5 pb-5 mt-2">
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
                <div class="row pt-5">
                        @forelse($audiobooks as $book)
                                <div class="col-sm-4">
                                        
                                        <div class="panel panel-default">
                                                <a href="{{ route('audiobook.show', $book->id) }}">

                                                        <div class="panel-heading" 
                                                        style="background-image:url({{ $book->thumbnail }}); background-size:cover; background-position:center; padding-top:75%" ></div>
                                                </a>
                                                <div class="panel-body" style="min-height: 85px;">
                                                        <h4 class="mt-0">{{ $book->title }}</h4>
                                                </div>
                                        </div>                
                                </div>
                        @endforeach
                </div>
                {{ $audiobooks->appends(['q' => Request::get('q')])->links() }}
           
      </div>
@endsection