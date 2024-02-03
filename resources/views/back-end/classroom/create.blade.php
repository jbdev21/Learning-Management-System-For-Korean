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
                                    <label for="">Name</label>
                                    <input type="text" required name='name' value="{{ old('name') }}" class="form-control">
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
                                            <option value="{{ $subject->id }}">{{ $subject->abbreviation }}</option>
                                        @endforeach
                                    </select>
                                </p>
                                <p>
                                    <label for="">Teachers</label>
                                    <select name="subjects[]" id="" class="form-control select2" multiple>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
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
            </div>
           
        </div>
      </div>
@endsection

