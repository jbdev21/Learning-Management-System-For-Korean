@extends("back-end.includes.layouts.main")  
@section('page-title','Teachers')
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
                            <form action="{{ route('back-end.teacher.store')}}" method="POST" >  
                                @csrf
                           
                                <p>
                                    <label for="">Teacher Name</label>
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
                                        <option value="Leave">Leave</option>
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
                    <div class="text-right">
                        <button class="btn btn-danger" id='delete-all-btn'><i class="fa fa-trash"></i> Delete</button>
                    </div>
                    <form action="{{ route('back-end.teacher.destroy', 0) }}" method="POST" id="delete-all-form">
                        @method('DELETE') @csrf
                        <div class="table-responsive">
                            <table class="table">   
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="checkAll"></th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($teachers as $teacher)
                                        <tr id="item-{{ $teacher->id }}">
                                            <td><input type="checkbox" name="checkedItems[]" value="{{ $teacher->id }}"></td>
                                            <td>{{ $teacher->username }}</td>
                                            <td>{{ $teacher->name }}</td>
                                            <td>{{ $teacher->contact_number }}</td>
                                            <td>{{ $teacher->email }}</td>
                                            <td>{{ ucfirst($teacher->status) }}</td>
                                            <td class="text-right">
                                                <a class="btn btn-xs btn-primary" href="{{ route('back-end.teacher.edit', $teacher->id) }}"><i class="fa fa-pencil"></i> Edit</a>
                                                <button type="button" class="btn btn-xs btn-danger delete-item" data-remove="#item-{{ $teacher->id }}" data-uri="{{ route('back-end.teacher.destroy', $teacher->id) }}"><i class="fa fa-trash"></i> Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    {{-- {!! $html->table() !!} --}}
                    </form>
                </div>
            </div>
           
        </div>
      </div>
@endsection