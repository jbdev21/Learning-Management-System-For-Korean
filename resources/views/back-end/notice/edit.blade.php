@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Edit Notice')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ ucfirst($notice->type) ?? 'Notice'}}</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.notice.update', $notice->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>
                                            <label for="">Title</label>
                                            <input type="text" required name='title' value="{{ $notice->title }}" class="form-control">
                                        </p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>
                                            <label for="">Status</label>
                                            <select name="is_published" id="" class="form-control">
                                                <option value="1">Publish</option>
                                                <option value="0" @if($notice->is_published) selected @endif>Draft</option>
                                            </select>
                                        </p>
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea class="editor" name="content">{!! $notice->content !!}</textarea>     
                                    </div>
                                </div>
                             
                             
                                <p class="mt-5">
                                    <button type="submit" class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
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