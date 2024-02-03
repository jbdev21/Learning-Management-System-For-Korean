@extends("back-end.includes.layouts.main")  
  

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Grammar</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.grammar.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>
                                            <label for="">Title</label>
                                            <input type="text" required name='title' value="{{ old('title') }}" class="form-control">
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>
                                            <label for="">Status</label>
                                            <select name="is_published" id="" class="form-control">
                                                <option value="1">Publish</option>
                                                <option value="0" @if(old('is_pusblished')) selected @endif)>Draft</option>
                                            </select>
                                        </p>
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea class="editor" name="content">{!!  old('name') !!}</textarea>     
                                    </div>
                                </div>
                             
                             
                                <p class="mt-5">
                                    <button type="submit" class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save Chances</button>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
            </div>
           
        </div>
      </div>
@endsection

@push('scripts')
@include("back-end.includes.components.tinymce-editor");
@endpush