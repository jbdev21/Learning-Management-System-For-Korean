@extends("back-end.includes.layouts.main")  

@section('page-title', 'Student Rank')

@section('content')
      <div class="box">
            <div class="box-header with-border">
                  <div class="row">
                        <div class="col-sm-8">
                              <h3 class="box-title">Student Rank</h3>
                        </div>
                        <div class="col-sm-4">
                              <form>
                                    <div class="input-group">
                                          <input type="text" name="student_name" value="{{ Request::get('student_name') }}" style="border-radius: 0px !important;" class="form-control" placeholder="Search student name...">
                                          <span class="input-group-btn">
                                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                          </span>
                                    </div><!-- /input-group -->
                              </form>
                        </div>
                  </div>

            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading"> Edit Rank</div>
                            <div class="panel-body">
                                @include('back-end.includes.alerts.errors')
                                <form action="{{ route('back-end.student-rank.update', $month) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <p>
                                        <label for="">Month</label>
                                        <input required type="month" id="month-input" name="month" readonly class="form-control" value="{{ $monthFormat }}">
                                        
                                    </p>
                                    <p>
                                        <label for="">1st Place</label>
                                        @if($firstStudent)
                                            <input type="text" value="{{$firstStudent->student->username}}({{ $firstStudent->student->name }})" readonly class="form-control">
                                            <input type="hidden" name="first_id" value="{{ $firstStudent->student->id }}">
                                        @else
                                            <select required class="form-control select2" name="first_id" >
                                                @foreach($students as $studentSelection2)
                                                    <option value="{{ $studentSelection2->id }}">{{ $studentSelection2->username }}: {{ $studentSelection2->name }}</option>
                                                @endforeach
                                            </select>
                                            <small class="help-block" style="color:rgb(245, 132, 132)">&nbsp;&nbsp;&nbsp; * System generated not yet available</small>
                                        @endif
                                    </p>
                                    <p>
                                        <label for="">2nd Place</label>
                                        <select required class="form-control select2" name="second_id" style="margin-right:5px" >
                                            @foreach($students as $studentSelection)
                                                <option value="{{ $studentSelection->id }}" @if($secondStudent->id == $studentSelection->id) selected @endif >{{ $studentSelection->username }}: {{ $studentSelection->name }}</option>
                                            @endforeach
                                        </select>
                                    </p>
                                    <p>
                                        <small>Note: if month already in the list it will replace.</small>
                                    </p>
                                    <p class="mt-3">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                        <a href="{{ route('back-end.student-rank.index') }}" class="btn btn-default"><i class="fa fa-ban"></i> Cancel</a>
                                    </p>
                                </form>
                                <form id="form-month-changer">
                                    <input type="hidden" name="month" id="month-placeholder">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
            