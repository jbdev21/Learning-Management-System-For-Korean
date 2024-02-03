@extends("back-end.includes.layouts.main")  
@section('page-title', 'Add New Audio Book')
@section('content-header')
    <h1>
        Audio Books
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com">Home</a></li>
        <li class="{{ route('back-end.audiobook.index') }}">Audio Book</li>
        <li class="active">Create</li>
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
                    <form action="{{ route('back-end.audiobook.store') }}" method="POST" enctype="multipart/form-data">
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
                        <p>
                            <label for="">Source Type</label>
                            <select class="form-control" name='source_type' role="">
                                <option value="hosted">Hosted</option>
                                <option value="outsource">Outsouce</option>
                                <option value="youtube_video">Youtube Video</option>
                            </select>
                        </p>
                        <p>
                            <label for="" id="source_folder">Source Folder</label>
                            <input type="text" name="source_folder"  value="{{ old('source_folder') }}" class="form-control">
                        </p>
                        <p>
                            <label for="">Thumbnail</label> <br>    
                            <audiobook-thumbnail-component ></audiobook-thumbnail-component>
                        </p>
    

                        <div class="text-right">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Save</button>
                            <a href="{{ route('back-end.audiobook.index') }}"  class="btn btn-default"><i class="fa fa-ban"></i> Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            var sourceFolderChanged = false
            var name            = $('[name=title]')
            var source_folder   = $('[name=source_folder]')
            var source_type   = $('[name=source_type]')

            name.keyup(function(){
                if(!sourceFolderChanged){
                    val = name.val()
                    source_folder.val(val.split(' ').join('_').toLowerCase())
                }
            })
            
            $('[name=source_type]').change(function(e){
                var defaultHtml = "Source Folder"
                if($(this).val() == "youtube_video"){
                    $('#source_folder').html("Youtube link")
                    $('[name=source_folder]').attr('type', 'url')
                }else{
                    $('#source_folder').html(defaultHtml)
                    $('[name=source_folder]').attr('type', 'text')
                }
            })

            source_folder.keyup(function(){
                if(source_folder.val() == ""){
                    sourceFolderChanged = false
                }else{
                    sourceFolderChanged = true
                }
            })
        })
    </script>
@endpush

