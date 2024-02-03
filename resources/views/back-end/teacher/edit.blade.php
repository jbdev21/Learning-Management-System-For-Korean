@extends("back-end.includes.layouts.main")  
@section('page-title','Edit ' . $teacher->name)
@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Teacher</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('back-end.teacher.update', $teacher->id)}}" method="POST" >  
                                @csrf
                                @method('PUT')
                                <p>
                                    <label for="">Teacher Name</label>
                                    <input type="text" name='name' value="{{ $teacher->name }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Email</label>
                                    <input type="text" name='email' value="{{ $teacher->email }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Contact Number</label>
                                    <input type="text" name='contact_number'  value="{{ $teacher->contact_number }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="working">Working</option>
                                        <option value="Leave" @if($teacher->status == "Leave") selected @endif >Leave</option>
                                        <option value="quit" @if($teacher->status == "quit") selected @endif >Quit</option>
                                    </select>
                                </p>
                                <div class="mt-4 text-center">
                                    <small class='text-muted'><i> For account</i></small>
                                </div>
                                <p>
                                    <label for="">Username</label>
                                    <input type="text" name='username'  value="{{ $teacher->username }}" class="form-control">
                                </p>
                                <p>
                                    <label for="">Password <small><i>(change password if provided)</i></small></label>
                                    <input type="password" name='password'  class="form-control">
                                </p>

                                <p>
                                    <button type='submit' class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
            </div>
           
        </div>
      </div>
@endsection
