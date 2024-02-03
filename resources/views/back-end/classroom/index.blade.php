@extends("back-end.includes.layouts.main")  

@section('page-title', 'Class Rooms')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Class Rooms</h3>
        </div>
        <div class="box-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                         
                            <form action="{{ route('back-end.class-room.store') }}" method="POST">
                                @csrf
                                <p>
                                    <label for="">Class Room</label>
                                    <input type="text" required name='name' value="{{ old('name') }}" class="form-control">
                                    @error('name')
                                        <div class="text-danger" role="alert">
                                            * {{ $message }}
                                        </div>
                                    @enderror
                                </p>
                                <p>
                                    <label for="">Subjects</label>
                                    <select name="subjects[]" id="" class="form-control select2" style="border-radius:25px;" multiple>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}">{{ $subject->abbreviation }}</option>
                                        @endforeach
                                    </select>
                                </p>
                                <p>
                                    <label for="">Teachers</label>
                                    <select name="teachers[]" id="" class="form-control select2" multiple>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->username }}({{ $teacher->name }})</option>
                                        @endforeach
                                    </select>
                                </p>

                                <p>
                                    <button type="submit" class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save</button>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-sm-8 table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Class Room</th>
                                <th>Subjects</th>
                                <th>Teachers</th>
                                <th>Students</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classrooms as $room)
                                <tr>
                                    <td>{{ $room->name }}</td>
                                    <td>
                                        {{ $room->subjects->implode('abbreviation', ' / ') }}
                                    </td>
                                    <td>
                                        {{ $room->teachers->implode('name', ' / ') }}
                                    </td>
                                    <td>
                                        {{ $room->students->count() }}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('back-end.class-room.show', $room->id) }}" class="btn btn-xs btn-primary "><i class="fa fa-eye"></i> Show</a>
                                        <a href="{{ route('back-end.class-room.edit', $room->id) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>
                                        <a href="#" onclick="if(confirm('Are you sure to delete?')){ $('#form-{{ $room->id }}').submit() }" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                        <form action="{{ route('back-end.class-room.destroy', $room->id) }}" id="form-{{ $room->id }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td align="center" colspan="3">No Class Room</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
           
        </div>
      </div>
@endsection

