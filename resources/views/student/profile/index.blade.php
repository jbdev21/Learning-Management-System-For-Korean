@extends("student.includes.layouts.main")  
@section('page-title', 'Profile')
@section('content')
        <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                        <h1>Profile</h1>
                        @include('student.includes.alerts.error')
                        @include('student.includes.alerts.message')
                        <div class="box p-5">
                                <form action="{{ route('student.profile.update')}}" method="POST"  enctype="multipart/form-data">  
                                        <div class="row">
                                                <div class="col-sm-4 pl-5">
                                                @csrf
                                                @method('PUT')
                                                <p>
                                                        <label for="">* Name</label>
                                                        <input type="text" readonly name='name' value="{{ old('name')  ?? $user->name }}" class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">* Contact Number</label>
                                                        <input type="text" readonly name='contact_number'  value="{{ old('contact_number')  ?? $user->contact_number }}" class="form-control">
                                                </p>
                                                <p>
                                                        <label for="">* Email Address</label>
                                                        <input type="text" readonly name='email'  value="{{ old('email')  ?? $user->email }}" class="form-control">
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
                                                        <img src="{{ $user->avatar }}" alt="" class="img img-responsive">
                                                </div>
                                                <input type="file" class="hidden" id='file-logo' name="avatar" accept="image/*">
                                                <br>
                                                <label for="file-logo" class="btn btn-default">Change</label>
                                                </div>
                                        </div>
                                </form>
                        </div>
                </div>
        </div>
@endsection