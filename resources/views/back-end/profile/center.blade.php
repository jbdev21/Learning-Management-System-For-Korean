@extends("back-end.includes.layouts.main")

@section('page-title', ' Center Profile')

@section('content')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
              @if(Auth::user()->type != "teacher")
                <li ><a href="{{ route('back-end.profile.index') }}" >Profile</a></li>
            @endif
            <li><a href="{{ route('back-end.profile.changepassword') }}" >Change Password</a></li>
            @if(Auth::user()->type != "teacher")
                <li class="active"><a href="{{ route('back-end.profile.center.index') }}" >Center</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <br>
                <form action="{{ route('back-end.profile.center.update') }}" method="POST">
                        @csrf
                          <p>
                                <label for="">Registration Number</label>
                                <input type="text" name='registration_number' value="{{ $center->registration_number }}" class="form-control">
                        </p>
                        <p>
                                <label for="">Center Name</label>
                                <input type="text" required name='center_name' value="{{ $center->center_name }}" class="form-control">
                        </p>
                        <p>
                                <label for="">Email Address</label>
                                <input type="text" name='email_address' value="{{ $center->email_address }}" class="form-control">
                        </p>
                        <p>
                                <label for="">Fax Number</label>
                                <input type="text" name='fax_number' value="{{ $center->fax_number }}" class="form-control">
                        </p>
                        <p>
                                <label for="">Contact Number</label>
                                <input type="text"   name='contact_number' value="{{ $center->contact_number }}" class="form-control">
                        </p>
                        <p>
                                <label for="">Address</label>
                                <input type="text"  name='address' value="{{ $center->address }}" class="form-control">
                        </p>
                        <p>
                                <button type="submit" class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                        </p>
                </form>
            </div>
        </div>
    </div>
@endsection
