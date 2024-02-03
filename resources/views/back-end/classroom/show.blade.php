@extends("back-end.includes.layouts.main")  

@section('page-title', 'Class Rooms')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Class Rooms</h3>
        </div>
        <div class="box-body">
            <a href="{{ route('back-end.class-room.index') }}" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
            <h2>{{ $room->name }}</h2>
            <br>
          
            <div class="panel panel-default">
                <div class="panel-heading">
                Students
                </div>
                <div class="panel-body">
                    <form action="{{ route('back-end.class-room.user.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="classroom" value="{{ $room->id }}">
                        <div class="input-group input-group-sm" style="width:350px">
                            <select class="form-control select2" name="users" style="margin-right:5px" >
                                @foreach($students as $studentSelection)
                                    <option value="{{ $studentSelection->id }}">{{ $studentSelection->username }}: {{ $studentSelection->name }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-btn ml-3">
                                <button style='margin-left:10px;' type="submit" class="btn btn-info btn-lg">Add</button>
                            </span>
                        </div>
                    </form>
                    
                    <table class="table">
                        <thead>
                            <tr>
                                <th>UserName</th>
                                <th>Name</th>
                                <th>Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($room->students as $student)
                                <tr>
                                    <td>{{ $student->username }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->grade }}</td>
                                    <td class='text-right'>
                                    <a href="#" class='btn btn-xs btn-danger' onclick="if(confirm('Are you sure to delete?')){ $('#delete-{{ $student->id }}').submit() }"><i class="fa fa-remove"></i> Remove</a>
                                        <form style="display: none;" id="delete-{{ $student->id }}" action="{{ route('back-end.class-room.user.remove', $room->id) }}" method="POST">@csrf
                                            <input type="hidden" name="users[]" value="{{ $student->id }}">
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No Student</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
      </div>
@endsection

