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
                            <div class="panel-heading"> New Rank</div>
                            <div class="panel-body">
                                @include('back-end.includes.alerts.errors')
                                <form action="{{ route('back-end.student-rank.store') }}" method="POST">
                                    @csrf
                                    <p>
                                        <label for="">Month</label>
                                        <input required type="month" id="month-input" name="month" class="form-control" value="{{ Request::get('month') ?? date('Y-m') }}">
                                    </p>
                                    <p>
                                        <label for="">1st Place</label>
                                        {{-- @if($firstStudent->average)
                                            <input type="text" value="{{$firstStudent->username}}({{ $firstStudent->name }})" readonly class="form-control">
                                            <input type="hidden" name="first_id" value="{{ $firstStudent->id }}">
                                            <small class="pl-2"><i>{{ $firstStudent->username  }} with average score of {{ round($firstStudent->average, 2) }}</i></small>
                                        @else --}}
                                            <select required class="form-control select2" name="first_id" >
                                                @foreach($students as $studentSelection2)
                                                    <option @if($firstStudent->id == $studentSelection2->id) selected @endif value="{{ $studentSelection2->id }}">{{ $studentSelection2->username }}: {{ $studentSelection2->name }}</option>
                                                @endforeach
                                            </select>
                                        @if($firstStudent->average)
                                            <small class="pl-2"><i>{{ $firstStudent->username  }} with average score of {{ round($firstStudent->average, 2) }}</i></small>
                                        @else
                                            <small class="help-block" style="color:rgb(245, 132, 132)">&nbsp;&nbsp;&nbsp; * System generated not yet available</small>
                                        @endif
                                    </p>
                                    <p>
                                        <label for="">2nd Place</label>
                                        <select required class="form-control select2" name="second_id" style="margin-right:5px" >
                                            @foreach($students as $studentSelection)
                                                <option value="{{ $studentSelection->id }}"
                                                    @if($secondStudent->average)
                                                        @if($secondStudent->id == $studentSelection->id)
                                                            selected
                                                        @endif
                                                    @endif
                                                    >{{ $studentSelection->username }}: {{ $studentSelection->name }}</option>
                                            @endforeach
                                        </select>
                                        @if($secondStudent->average)
                                            <small class="pl-2"><i>{{ $secondStudent->username  }} with average score of {{ round($secondStudent->average, 2) }}</i></small>
                                        @endif
                                    </p>
                                    <p>
                                        <small>Note: if month already in the list it will replace.</small>
                                    </p>
                                    <p class="mt-3">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                    </p>
                                </form>
                                <form id="form-month-changer">
                                    <input type="hidden" name="month" id="month-placeholder">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <table class="table">
                            <thead>
                                <tr>
                                        <td>Month</td>
                                        <td>Ranks</td>
                                        <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ranks as $rank)
                                    <tr>
                                        <td>{{ date('M, Y', strtotime($rank['month'])) }}</td>
                                        <td>
                                            @foreach($rank['ranks'] as $student)
                                                
                                                <div class="mb-2">
                                                    @if($student['rank'] == 1)
                                                        <img src="/images/index/first-medal.png" style="width:25px;" alt="">
                                                    @else
                                                        <img src="/images/index/2nd-medal.png" style="width:25px;" alt="">
                                                    @endif

                                                    {{ $student['student'] }}
                                                </div>
                                            @endforeach
                                        </td>
                                        <td class="text-right">
                                            {{-- <a href="{{ route('back-end.student-rank.edit', $rank['month']) }}" class="btn btn-default"> <i class="fa fa-edit"></i> Edit</a> --}}
                                            <button href="#" class="btn btn-danger" 
                                                onclick="if(confirm('Are you sure to delete?')){ $('#rank-{{ $rank['month'] }}').submit() }"
                                                > 
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                            <form method="POST" action="{{ route('back-end.student-rank.destroy', $rank['month']) }}" id="rank-{{ $rank['month'] }}"> @csrf @method("DELETE")</form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $ranks->appends(['month' => Request::get('month')])->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
            
@push('scripts')
    <script>
        $(document).ready(function(){
            
            $('#month-input').change(function(){
                var val = $(this).val()
                $('#month-placeholder').val(val)
                $('#form-month-changer').submit()
            })
        })
    </script>
@endpush