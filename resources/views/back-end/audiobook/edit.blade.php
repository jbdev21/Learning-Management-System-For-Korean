@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Edit Audio Book')

@section('content-header')
    <h1>
       Audio Books
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="{{ route('back-end.audiobook.index') }}">Audio Book</li>
        <li class="active">Edit Audio Book</li>
    </ol>
@endsection

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Audio Books</h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <form action="{{ route('back-end.audiobook.update', $book->id) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="">Source Type </label>
                        <select class="form-control" name='source_type'>
                            <option value="hosted">Hosted</option>
                            <option value="outsource" @if($book->source_type == "outsource") selected @endif >Outsource</option>
                            <option value="youtube_video" @if($book->source_type == "youtube_video") selected @endif >Youtube Video</option>
                        </select>
                    </p>
                    <p>
                        @if($book->source_type == "youtube_video")
                            <label for="">Youtube Link</label>
                        @else
                            <label for="">Source Folder</label>
                        @endif
                        <input type="text" name="source_folder" value="{{ $book->source_folder }}" class="form-control">
                    </p>
                    <p>
                        <label for="">Thumbnail</label> <br>    
                        <audiobook-thumbnail-component source-type="{{ $book->thumbnail_source_type }}" source="{{ $book->thumbnail }}"  ></audiobook-thumbnail-component>
                    </p>

                    <div class="text-right">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
                        <a href="{{ route('back-end.audiobook.index') }}"  class="btn btn-default"><i class="fa fa-ban"></i> Cancel</a>
                    </div>
                </form>
        </div>
            <div class="col-sm-6">
                <label for="">Audio Files</label>
                @if($book->source_type == "youtube_video")
                    <div class="embed-responsive embed-responsive-16by9 mw-100">
                        <iframe class="embed-responsive-item" src="{{ youtubeEmbedFromUrl($book->source_folder) }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                @else
                    <form action="{{ route('back-end.audiobook.uploadfile', $book->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" name='type' value="audiofile">
                        <label for="input-audio-file" class='btn btn-default'><i class="fa fa-plus"></i> Add Audio File</label>
                        <input type="file" accept="audio/*" id="input-audio-file" name="uploadedfile" style="display:none;">
                    </form>
                    
                    <table class="table table-stripped mt-2">
                        @foreach($book->getAudioFiles() as $index => $file)
                            <tr id='file-{{ $index }}'>
                                <td>
                                    {{ str_replace($book->source_folder . '/', '', $file) }}
                                </td>
                                <td class="text-right">
                                    <button  href="#" data-remove="#file-{{ $index }}" data-uri="{{ route('back-end.audiobook.deletefile', $book->id) }}?path={{ $file }}" class="btn btn-xs delete-item"><i class="fa fa-remove"></i> Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#input-audio-file').change(function(){
                $(this).closest('form').submit();
            })
        })
    </script>
@endpush