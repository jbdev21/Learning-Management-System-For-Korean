@extends("back-end.includes.layouts.main")  

@section('page-title', ' Center Profile')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Center Profile</h3>
        </div>
        <div class="box-body">
             
                <div class="row">
                    <div class="col-sm-4 pl-5">
                         <form action="{{ route('back-end.banner.store')}}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <p>
                                <label for="">Banner Image</label>
                                <input type="file" name="banner" required>
                            </p>
                            <p>
                                <label for="">Date Show *</label>
                                <input type="date"  required name='show_start' value="{{ old('show_start') ?? date('Y-m-d') }}" class="form-control">
                            </p>
                            <p>
                                <label for="">Date Show End</label>
                                <input type="date" name='show_end'  value="{{ old('show_end') }}" class="form-control">
                            </p>
                            <p>
                                <label for="">Link</label>
                                <input type="url" name='link'  value="{{ old('link') }}" class="form-control">
                            </p>
                            <p>
                                <input type="checkbox" name="is_show" id="is_show" @if(old('is_show')) checked @endif>
                                <label for="is_show"> Show</label>
                            </p>
                        
                            <p>
                                <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                            </p>
                        </form>
                    </div>
                    <div class="col-sm-8">
                        <div class="row">
                            @foreach($banners as $banner)
                            <div class="col-sm-6">
                                <div class="panel">
                                    <div class="panel-body" style="padding:0px">
                                        <img src="{{ $banner->banner_image }}" alt="" class="img-responsive">
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                @if($banner->is_show) <i class="fa fa-eye"></i> @else <i class="fa fa-eye-slash"></i> @endif
                                                {{  $banner->show_start }} @if($banner->show_end) -{{  $banner->show_end }} @endif
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <a href="{{ route('back-end.banner.edit', $banner->id) }}"><i class="fa fa-pencil"></i> Edit</a> &nbsp; | &nbsp;
                                                <a href="#" onclick="if(confirm('Are you sure to delete?')) {$('#delete-{{ $banner->id }}').submit() }; return false; "><i class="fa fa-trash"></i> Delete</a>
                                                <form action="{{ route('back-end.banner.destroy', $banner->id) }}" style="display: none" id="delete-{{ $banner->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
      </div>
@endsection