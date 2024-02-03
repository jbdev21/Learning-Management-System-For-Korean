@extends("back-end.includes.layouts.main")
@section('page-title', 'Students')
@section('content-header')
    <h1>
        Student
    </h1>
    <ol class="breadcrumb">
        <li><a href="https://gwenglishacademy.com/">Home</a></li>
        <li class="active">Student</li>
    </ol>
@endsection

@section('content')
        <form action="{{ route('back-end.student.store') }}" method="POST" style="display:none" enctype="multipart/form-data" id="import-form">
            @csrf
            <input type="file" name="excelfile" id="excelfile">
        </form>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
              On-going: {{ $ongoing }}
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              Waiting: {{ $waiting }}
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              On-leave: {{ $onleave }}
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          </h3>

        </div>
        <div class="box-body">
            <div class="text-right">
                <a href="{{ route('back-end.student.export') }}" target="_blank" class="btn btn-warning">Download Excel</a>
                <label for='excelfile' class="btn btn-warning"><i class="fa fa-file-excel-o"></i>  Import Excel</label>
                {{-- <a href="{{ route('back-end.student.create') }}" class="btn btn-warning"><i class="fa fa-plus"></i> Create New</a> --}}
            </div>

            <div class='p-4'>
                <form>
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="">Class Room</label>
                            <select name="class" id="" class="form-control">
                                <option value="">- all class -</option>
                                @foreach($classRooms as $classRoom)
                                    <option @if(Request::get('class') == $classRoom->id) selected @endif value="{{ $classRoom->id }}">{{ $classRoom->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="">Mobile Number</label>
                            <input type="text" name="mobile"  value="{{ Request::get('mobile') }}"class="form-control">
                        </div>
                        <div class="col-sm-2">
                            <label for="">Status</label>
                            <select name="status" id="" class="form-control">
                                <option value="">- all status -</option>
                                <option value="waiting" @if(Request::get('status') == "waiting") selected @endif >Waiting</option>
                                <option value="on-going" @if(Request::get('status') == "on-going") selected @endif >On-going</option>
                                <option value="on-leave" @if(Request::get('status') == "on-leave") selected @endif >On-leave</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <label for="">Username/Name</label>
                            <input type="text" name="name" value="{{ Request::get('name') }}" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <label for="">&nbsp;</label><br>
                            <button class="btn btn-warning"><i class="fa fa-sort"></i> Search</button>
                            <a href="{{ route('back-end.student.index') }}" class="btn btn-warning"><i class="fa fa-ban"></i> Clear</a>
                            <button type="button" class="btn btn-danger" id="deleteAllBtn"><i class="fa fa-trash"></i> Delete</button>
                        </div>
                    </div>
                </form>
                <br>
                <form action="{{ route('back-end.student.destroy', 0) }}" id="deleteAllForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="table-responsive">   
                        <table class="table">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" name=''></th>
                                    <th>Username</th>
                                    <th style="width: 100px;">Name</th>
                                    <th>School</th>
                                    <th>Grade</th>
                                    <th>Student No.</th>
                                    <th>Parent No.</th>
                                    <th>Class</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                    <tr id="data-item-{{ $student->id }}">
                                        <td><input type="checkbox" value="{{ $student->id }}" name='checkitems[]'></td>
                                        <td>{{ $student->username }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ optional($student->data)->school_name }}</td>
                                        <td>{{ config('grading.' . optional($student->data)->grade) }}</td>
                                        <td>{{ $student->contact_number }}</td>
                                        <td>{{ optional($student->data)->parent_contact_number }}</td>
                                        <td>{{ $student->classes }}</td>
                                        <td>{{ ucfirst($student->status) }}</td>
                                        <td>
                                            <a title="ESSSAY" href="{{ route('back-end.writing.index', ['student' => $student->id]) }}" class="btn btn-primary btn-xs" style="margin-right:3px" href="#">E</a>
                                            <a title="DIARY" href="{{ route('back-end.diary.index', ['student' => $student->id]) }}" class="btn btn-primary btn-xs" style="margin-right:3px">D</a>
                                            <a title="RECORDINGS" href="{{ route('back-end.recording.index', ['student' => $student->id]) }}" class="btn btn-primary btn-xs" style="margin-right:3px" >R</a>
                                            <a title="GRAMMAR"  href="{{ route('back-end.examination.index', ['q' => $student->username]) }}" class="btn btn-primary btn-xs" href="#">G</a>
                                        </td>
                                        <td class="text-right">
                                            <a class="btn btn-xs btn-primary" href="{{ route('back-end.student.show', $student->id) }}?type=erp" ><i class="fa fa-eye"></i> Read</a>
                                            <a class="btn btn-xs btn-primary" href="{{ route('back-end.student.show', $student->id) }}?type=asw" ><i class="fa fa-eye"></i> Essay</a>
                                            <a class="btn btn-xs btn-warning" href="{{ route('back-end.student.edit', $student->id) }}" ><i class="fa fa-pencil"></i> Edit</a>
                                            <button type="button" class="delete-item btn btn-xs btn-danger" data-uri="{{ route('back-end.student.destroy', $student->id) }}" data-remove="#data-item-{{ $student->id }}"  ><i class="fa fa-trash"></i> Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="11"> No student found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </form>
                    {{ $students->appends([
                        'status' => Request::get('status'),
                        'name' => Request::get('name'),
                        'mobile' => Request::get('mobile'),
                        'class' => Request::get('class'),
                    ])->links() }}

            </div>

        </div>
      </div>
@endsection

@push('scripts')
        <script>
                $(document).ready(function(){
                        $('#excelfile').change(function(){
                                $('#import-form').submit();
                        })
                })
        </script>
@endpush


