@extends("back-end.includes.layouts.main")  
  

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Branch</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.branch.store') }}" method="POST">
                                @csrf
                                <p>
                                    <label for="">Registration Number</label>
                                    <input type="text" required name='registration_number' value="{{ old('registration_number') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Domain</label>
                                    <input type="text" required name='domain' value="{{ old('domain') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Center Name</label>
                                    <input type="text" required name='center_name' value="{{ old('center_name') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Email Address</label>
                                    <input type="text" name='email_address' value="{{ old('email_address') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Fax Number</label>
                                    <input type="text" name='fax_number' value="{{ old('fax_number') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Contact Number</label>
                                    <input type="text"  required name='contact_number' value="{{ old('contact_number') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Address</label>
                                    <input type="text" required name='address' value="{{ old('address') }}" class="form-control">
                                </p>
                                <p>
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
