@extends("back-end.includes.layouts.main")  

@section('page-title', 'Diary Entry & Journal')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Diary Entry & Journal</h3>
        </div>
        <div class="box-body">
            <div class="row">
              <div class="col-sm-4">
                <div class="panel panel-default">
                  <div class="panel-heading">Filter Diary</div>
                  <div class="panel-body">
                    <form>
                      @if(auth()->user()->type == "administrator")
                      <p>
                        Branch
                        <select name="branch" id="" class="form-control">
                          @foreach($branches as $branch)
                            <option @if(Request::get('branch')) @if(Request::get('branch') == $branch->id) selected  @endif  @else @if($branch->id == auth()->user()->branch_id) selected  @endif  @endif value="{{ $branch->id }}">{{ $branch->center_name }}</option>
                          @endforeach
                        </select>
                      </p>
                      @endif
                      <p>
                        Title
                        <input type="text" name='title' value="{{ Request::get('title') }}" placeholder=" title.." class="form-control">
                      </p>
                      <p>
                        Student
                        <input type="text" name='studentName' value="{{ Request::get('studentName') }}" placeholder=" student name.." class="form-control">
                      </p>
                      <p>
                        Date From
                        <input type="date" name='date_from' value="{{ Request::get('date_from') }}" class="form-control">
                      </p>
                      <p>
                        Date To
                        <input type="date" name='date_to' value="{{ Request::get('date_to') }}" class="form-control">
                      </p>
                      <p>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Search</button>
                      </p>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-sm-8">
                @if(auth()->user()->type == "administrator")
                <div class="row mb-2">
                  <div class="col-sm-3">
                       <form id="select-branch-form">
                          <select name="branch" id="branch-select" class="form-control">
                              <option value="">-- All Branch --</option>
                              @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->center_name }}</option>
                              @endforeach
                          </select>
                      </form>
                  </div>
                </div>
               @endif
               <div class="table-responsive">   
                <table class="table">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Student</th>
                      <th>Date</th>
                      @if(auth()->user()->type == "administrator")
                      <th>Branch</th>
                      @endif
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($diaries as $diary)
                      <tr id="diary-{{ $diary->diary_id }}">
                        <td>{{ Str::limit($diary->title, 50) }}</td>
                        <td>{{ $diary->username }}({{ $diary->student_name }})</td>
                        <td>{{ $diary->date }}</td>
                            @if(auth()->user()->type == "administrator")
                            <td>{{ $diary->branch_name }}</td>
                            @endif
                        <td class='text-right'>
                          <a href="{{ route('back-end.diary.show', $diary->diary_id) }}" class="btn btn-xs btn-primary"><i class="fa fa-folder"></i> Show</a>
                          <a href="#" data-remove="#diary-{{ $diary->diary_id }}"  data-uri="{{  route('back-end.diary.destroy', $diary->diary_id) }}" class="delete-item btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>
                        </td>
                      </tr>
                    @empty
                        <tr>
                          <td class='text-center text-muted' colspan="4"><h4>No Diary</h4></td>
                        </tr>
                    @endforelse
                  </tbody>
                </table>
               </div>
                {{ $diaries->links() }}
              </div>
            </div>
           
        </div>
      </div>
@endsection

