@extends("back-end.includes.layouts.main")  

@section('page-title', ' Center Profile')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Center Profile</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('back-end.banner.update', $banner->id)}}" method="POST"  enctype="multipart/form-data">  
                <div class="row">
                    <div class="col-sm-4 pl-5">
                            @csrf
                            @method('PUT')
                            <p>
                                <label for="">Banner Image</label>
                                <input type="file" name="banner" style="margin-bottom:5px;">
                                <img src="{{ $banner->banner_image }}" class="img-responsive" alt="">
                            </p>
                            <p>
                                <label for="">Date Show *</label>
                                <input type="date"  required name='show_start' value="{{ old('show_start') ?? $banner->show_start }}" class="form-control">
                            </p>
                            <p>
                                <label for="">Date Show End</label>
                                <input type="date" name='show_end'  value="{{ old('show_end')?? $banner->show_end }}" class="form-control">
                            </p>
                            <p>
                                <label for="">Link</label>
                                <input type="url" name='link'  value="{{ old('link') ?? $banner->link }}" class="form-control">
                            </p>
                            <p>
                                <input type="checkbox" name="is_show" id="is_show" @if(old('is_show') || $banner->is_show == 1) checked @endif>
                                <label for="is_show"> Show</label>
                            </p>
                        
                            <p>
                                <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                <a href="{{ route('back-end.banner.index') }}" class="btn btn-default btn-md rounded-0"><i class="fa fa-ban"></i> Cancel</a>
                            </p>
                    </div>
                </div>
            </form>
        </div>
      </div>
@endsection