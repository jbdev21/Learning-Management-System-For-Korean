@extends("back-end.includes.layouts.main")  

@section('page-title', ' Center Profile')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Center Profile</h3>
        </div>
        <div class="box-body">
            <form action="{{ route('back-end.center.update', $branch->id)}}" method="POST"  enctype="multipart/form-data">  
                <div class="row">
                    <div class="col-sm-4 pl-5">
                            @csrf
                            @method('PUT')
                            <p>
                                <label for="">* Center Name</label>
                                <input type="text" name='center_name' value="{{ $branch->center_name }}" class="form-control">
                            </p>
                            <p>
                                <label for="">Fax Number</label>
                                <input type="text" name='fax_number' value="{{ old('fax_number') ?? $branch->fax_number }}" class="form-control">
                            </p>
                            <p>
                                <label for="">Contact Number</label>
                                <input type="text" name='contact_number'  value="{{ old('contact_number')  ?? $branch->contact_number }}" class="form-control">
                            </p>
                            <p>
                                <label for="">Email Address</label>
                                <input type="text" name='email_address'  value="{{ old('email_address')  ?? $branch->email_address }}" class="form-control">
                            </p>
                        
                            <p>
                                <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                            </p>

                            <p class="text-muted mt-5">
                                <i>
                                * registered on {{ $branch->created_at->format('M d, Y') }}
                                </i>
                            </p>

                    
                    </div>
                    <div class="col-sm-8">
                        <label for="">Images</label>
                        <div class="p-4">
                            <img src="{{ $branch->logo_path }}" alt="" class="img img-responsive" id="picture-preview">
                        </div>
                        <input type="file" class="hidden" id='file-logo' name="logo" accept="image/*">
                        <label for="file-logo" class="btn btn-default">Change</label>
                    </div>
                </div>
            </form>
        </div>
      </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#file-logo').on('change', function(){
                var file = $(this).get(0).files[0];
                if(file){
                    var reader = new FileReader();
                    reader.onload = function(){
                        $("#picture-preview").attr("src", reader.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        })
    </script>
@endpush