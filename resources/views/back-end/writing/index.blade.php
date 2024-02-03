@extends("back-end.includes.layouts.main")  
  
@section('page-title', 'Writings')

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Writings</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
            </div>
        <div class="table-responsive">   
            <div class="div-table" style="margin-bottom: 0px;">
                    <form class="tr">
                        <span class="td"><input placeholder=" search student.." type="text" name='name' value="{{ Request::get('name') }}" class="form-control"></span>
                        <span class="td">
                            <select name="class"  class="wide form-control niceselect" >
                                <option value=""> - All Class -</option>
                                @foreach($classRooms as $room) 
                                    <option @if(Request::get('class') == $room->id) selected @endif value="{{ $room->id }}"> {{ $room->name }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="td"><input placeholder=" search book.." type="text" name='title' value="{{ Request::get('title') }}"  class="form-control"></span>
                        <span class="td"><input placeholder=" search type.." type="text" name='type' value="{{ Request::get('type') }}"  class="form-control"></span>
                        <span class="td"><input placeholder=" search type name.." type="text" name='type_name' value="{{ Request::get('type_name') }}"  class="form-control"></span>
                        {{-- <span class="td"><input placeholder=" search author.." type="text" name='author' value="{{ Request::get('author') }}"  class="form-control"></span> --}}
                        <span class="td"><input placeholder=" search level.." type="text" name='ar_level' value="{{ Request::get('ar_level') }}"  class="form-control"></span>
                        <span class="td">
                            <select name="status"  class="wide form-control niceselect" >
                                <option value="">All Status</option>
                                <option value="Ongoing" @if(Request::get('status') == "Ongoing") selected @endif >Ongoing</option>
                                <option value="DONE" @if(Request::get('status') == "DONE") selected @endif>Done</option>
                            </select>
                        </span>
                        <span class="td">
                            <button class="btn btn-block btn-warning" type="submit" style="max-width: 100px;"><i class="fa fa-sort"></i> Search</button>
                        </span>
                        <span class="td">
                            <a href="{{ route('back-end.writing.index') }}" class="btn btn-block btn-default" style="max-width: 100px;"><i class="fa fa-ban"></i> Clear</a>
                        </span>
                        <span class="td">
                            <button type="button" class="btn btn-danger" id="deleteAllBtn"><i class="fa fa-trash"></i> Delete</button>
                        </span>              
                    </form>
                </div>
                <form action="{{ route('back-end.writing.destroy', 0) }}" id="deleteAllForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="div-table">
                            <div class="tr">
                                <span class="th" style="width:20px;"><input type="checkbox" id="checkAll" name=''></span>
                                <span class="th" style="width:150px;">Student</span>
                                <span class="th">Class</span>
                                <span class="th">Book</span>
                                <span class="th">Series/Stage</span>
                                <span class="th">Series/Stage</span>
                                {{-- <span class="th">Author</span> --}}
                                <span class="th">AR Level</span>
                                <span class="th">Date/Time</span>
                                <span class="th">Status</span>
                                <span class="th"></span>
                            </div>
                            @forelse($writings as $writing)
                                <div class="tr">
                                    <span class="td" style="width:20px;"><input type="checkbox" value="{{ $writing->writing_id }}" name='checkitems[]'></span>
                                    <span class="td">{{ $writing->username . '(' .$writing->student_name . ')' }}</span>
                                    <span class="td">{{ $writing->class_room_names }}</span>
                                    <span class="td">{{ $writing->title }}</span>
                                    <span class="td">{{ $writing->type }}</span>
                                    <span class="td">{{ $writing->type_name }}</span>
                                    {{-- <span class="td">{{ $writing->author }}</span> --}}
                                    <span class="td">{{ $writing->ar_level }}</span>
                                    <span class="td" style="width:200px">
                                        {{ date('H:i:s  Y-m-d', strtotime($writing->last_modified)) }}
                                    </span>
                                    <span class="td" style="width:200px">
                                        @if($writing->sum_rating)
                                            <span class='text-info'>DONE</span>
                                        @else
                                            <span class='text-warning'>Ongoing</span>
                                        @endif
                                    </span>
                                    <span class="td" class="text-right">
                                        <a href="{{ route('back-end.writing.show', ['component' => $writing->component_id  ,'book' => $writing->book_id, 'student' => $writing->student ]) }}" class="btn btn-primary btn-xs btn-block"><i class="fa fa-eye"></i> Show</a>
                                    </span>
                                </div>
                            @empty
                                <div class="text-center">    
                                    <span  class="text-center"> No Excercise</td>
                                </div>
                            @endforelse
                    </div>
                </form>
            </div>
        </div>
        <div class="p-4">
            {{ $writings->appends([
                'name' => Request::get('name'),
                'student' => Request::get('student'),
                'class' => Request::get('class'),
                'title' => Request::get('title'),
                'type' => Request::get('type'),
                'type_name' => Request::get('type_name'),
                'ar_level' => Request::get('ar_level'),
                'status' => Request::get('status'),
            ])->links() }}
        </div>
      </div>
@endsection

