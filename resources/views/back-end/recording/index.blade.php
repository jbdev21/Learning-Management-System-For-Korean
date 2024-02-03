@extends("back-end.includes.layouts.main")  

@section('page-title', 'Recordings')

@section('content')
      <div class="box">
            <div class="box-header with-border">
                  <div class="row">
                        <div class="col-sm-8">
                              <h3 class="box-title">Recording</h3>
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
                  <div class="box-body table-responsive">
                        <table class="table">
                              <thead>
                                    <tr>
                                          <td width="50px"><input type="checkbox" id="checkAll"></td>
                                          <td>Student</td>
                                          <td>Recordings</td>
                                          <td>Last Update</td>
                                          {{-- <td></td> --}}
                                          <td></td>
                                    </tr>
                              </thead>
                              <tbody>
                                    @forelse($students as $student)
                                          <tr>
                                                <td><input type="checkbox"></td>
                                                <td>{{ $student->username }}({{ $student->name }})</td>
                                                <td>{{ $student->recordings()->count() }}</td>
                                                <td>{{ optional(optional($student->recordings()->orderBy('created_at', 'DESC')->first())->created_at)->format('Y-m-d h:iA') }}</td>
                                                {{-- <td>{{ $student->userRecordingCommentCheck()}}</td> --}}
                                                <td class="text-right">
                                                      <a href="{{ route('back-end.recording.show', $student->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i> Show</a>
                                                </td>
                                          </tr>
                                    @empty 
                                          <tr>
                                                <td colspan="4" class="text-center"> No recording found</td>
                                          </tr>
                                    @endforelse
                              </tbody>
                        </table>
                        {{ $students->appends(['student_name' => Request::get('student_name'), 'student' => Request::get('student')])->links() }}
                  </div>
            </div>
      </div>
@endsection
            
      