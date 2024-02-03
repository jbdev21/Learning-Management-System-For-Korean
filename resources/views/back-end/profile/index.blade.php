@extends("back-end.includes.layouts.main")  

@section('page-title', ' Profile')

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="{{ route('back-end.profile.index') }}" >Profile</a></li>
            <li ><a href="{{ route('back-end.profile.changepassword') }}" >Change Password</a></li>
            @if(Auth::user()->type != "teacher")
                <li><a href="{{ route('back-end.profile.center.index') }}" >Center</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <form action="{{ route('back-end.profile.update')}}" method="POST"  enctype="multipart/form-data">  
                    <div class="row">
                        <div class="col-sm-4 pl-5">
                            @csrf
                            @method('PUT')
                            <p>
                                <label for="">* Name</label>
                                <input type="text" required name='name' value="{{ old('name')  ?? $user->name }}" class="form-control">
                            </p>
                            <p>
                                <label for="">* Contact Number</label>
                                <input type="text" required name='contact_number'  value="{{ old('contact_number')  ?? $user->contact_number }}" class="form-control">
                            </p>
                            <p>
                                <label for="">* Email Address</label>
                                <input type="text" required name='email'  value="{{ old('email')  ?? $user->email }}" class="form-control">
                            </p>
                            <br>
                            <p>
                                <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                            </p>

                            <p class="text-muted mt-5">
                                <i>
                                * registered on {{ $user->created_at->format('M d, Y') }}
                                </i>
                            </p>
                        </div>
                        <div class="col-sm-8">
                            <label for="">Avatar</label>
                            <div class="p-4">
                                <img src="{{ $user->avatar }}" alt="" class="img img-responsive" id="picture-preview">
                            </div>
                            <input type="file" class="hidden" id='file-logo' name="avatar" accept="image/*">
                            <label for="file-logo" class="btn btn-default">Change</label>
                        </div>
                    </div>
                </form>
            </div>
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