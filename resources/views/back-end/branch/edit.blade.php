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
                            <form action="{{ route('back-end.branch.update', $branch->id) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <p>
                                    <label for="">Registration Number</label>
                                    <input type="text" required name='registration_number' value="{{ $branch->registration_number }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Domain</label>
                                    <input type="text" required name='domain' value="{{ $branch->domain }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Center Name</label>
                                    <input type="text" required name='center_name' value="{{ $branch->center_name }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Email Address</label>
                                    <input type="text" name='email_address' value="{{ $branch->email_address }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Fax Number</label>
                                    <input type="text" name='fax_number' value="{{ $branch->fax_number }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Contact Number</label>
                                    <input type="text"  required name='contact_number' value="{{ $branch->contact_number }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Address</label>
                                    <input type="text" required name='address' value="{{ $branch->address }}" class="form-control">
                                </p>
                                <p>
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
