@extends("back-end.includes.layouts.main")  

@section('page-title', ' Sub Administrator')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Sub Administrators</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.sub-admin.store')}}" method="POST" >  
                                @csrf
                           
                                <p>
                                    <label for="">Branch</label>
                                    <select name='branch_id'  class="form-control" required>
                                        @foreach($branches as $branch)
                                            <option value="{{ $branch->id }}">{{ $branch->center_name }}</option>
                                        @endforeach
                                    </select
                                </p>
                                <p>
                                    <label for="">Admin Name</label>
                                    <input type="text" name='name' value="{{ old('name') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Email</label>
                                    <input type="text" name='email' value="{{ old('email') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Contact Number</label>
                                    <input type="text" name='contact_number'  value="{{ old('contact_number') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="working">Working</option>
                                        <option value="leaved">Leaved</option>
                                        <option value="quit">Quit</option>
                                    </select>
                                </p>
                                <div class="mt-4 text-center">
                                    <small class='text-muted'><i> For account</i></small>
                                </div>
                                <p>
                                    <label for="">Username</label>
                                    <input type="text" name='username'  value="{{ old('username') }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Password</label>
                                    <input type="password" name='password'  class="form-control">
                                </p>
                                <p>
                                    <label for="">Repeat Password</label>
                                    <input type="password" name='password_confirmation' class="form-control">
                                </p>

                                <p>
                                    <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-sm-8">
                    {!! $html->table() !!}
                </div>
            </div>
           
        </div>
      </div>
@endsection


@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap.min.js"></script>
    {!! $html->scripts() !!}
@endpush

