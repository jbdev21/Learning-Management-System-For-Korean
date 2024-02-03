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
                         
                            <form action="{{ route('back-end.class-room.update', $room->id) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <p>
                                    <label for="">Name</label>
                                    <input type="text" required name='name' value="{{ $room->name }}" class="form-control">
                                    @error('name')
                                        <div class="text-danger" role="alert">
                                            * {{ $message }}
                                        </div>
                                    @enderror
                                </p>
                                <p>
                                    <label for="">Subjects</label>
                                    <select name="subjects[]" id="" class="form-control select2" multiple>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" @if(in_array($subject->id, $room->subjects->pluck('id')->toArray() ?? [])) selected @endif >{{ $subject->abbreviation }}</option>
                                        @endforeach
                                    </select>
                                </p>
                                <p>
                                    <label for="">Teacher</label>
                                    <select name="teachers[]" id="" class="form-control select2" multiple>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" @if(in_array($teacher->id, $room->teachers->pluck('id')->toArray() ?? [])) selected @endif >{{ $teacher->username }}({{ $teacher->name }})</option>
                                        @endforeach
                                    </select>
                                </p>

                                <p>
                                    <button type="submit" class="btn btn-warning btn-md rounded-0"><i class="fa fa-save"></i> Save Changes</button>
                                    <a  class="btn btn-default btn-md rounded-0" href="{{ route('back-end.class-room.index') }}"><i class="fa fa-ban"></i> Cancel</a>
                                </p>
                            </form>
                        </div>
                      </div>
                </div>
            </div>
           
        </div>
      </div>
@endsection

