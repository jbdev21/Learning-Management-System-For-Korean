@extends("student.includes.layouts.main")
@section('content')

<div class="box">
    <div class="header-title">
        <h1>Essay</h1>
        <div class="tag-line">
            영어 논술
        </div>
    </div>

    <div class="box-content">
        <div class="row">
            <div class="col-sm-3" id="side-filter">
                <div class="panel panel-default">
                    <div class="panel-heading"><i class="fa fa-filter"></i> Filter</div>
                    <div class="panel-body">
                        <form>
                            <p>
                                <label for="">Title</label>
                                <input type="text" name="title" value="{{ Request::get('title')  }}" class="form-control input-lg" placeholder=" search title..">
                            </p>
                            <br>
                            <p>
                                <label for="">Series/Stage</label>
                                <select name="type" id="" class="form-control input-lg">
                                    <option value="">All</option>
                                    <option value="Series" @if(Request::get('type') == "Stage") selected @endif>Series</option>
                                    <option value="Stage" @if(Request::get('type') == "Stage") selected @endif >Stage</option>
                                </select>
                            </p>
                            <br>
                            <p>
                                <label for="">Series Name / Stage Name</label>
                                <select name="type_name" id="" class="form-control input-lg">
                                    <option value="">All</option>
                                    @foreach($type_names as $type_name)
                                        <option value="{{ $type_name }}" @if(Request::get('type_name') == $type_name) selected @endif>{{ $type_name }}</option>
                                    @endforeach
                                </select>
                            </p>
                            <br>
                            {{-- <p>
                                <label for="">Author</label>
                                <input type="text" name="author" value="{{ Request::get('author')  }}"  class="form-control input-lg">
                            </p> <br> --}}
                            <p>
                                <label for="">AR Level</label>
                                <input type="text" name="ar_level" value="{{ Request::get('ar_level')  }}" class="form-control input-lg">
                            </p>
                            <br>
                            <p>
                                <label for="">Status</label>
                                <select name="status" id="" class="form-control input-lg">
                                    <option value="">All</option>
                                    <option value="Pending" @if(Request::get('status') == "Pending") selected @endif >Pending</option>
                                    <option value="Ongoing" @if(Request::get('status') == "Ongoing") selected @endif >Ongoing</option>
                                    <option value="DONE" @if(Request::get('status') == "DONE") selected @endif >Done</option>
                                </select>
                            </p>
                            <br>
                            <div class="text-center">
                                <button class="btn btn-block btn-lg btn-primary"><i class="fa fa-filter"></i> Filter </button>
                                <br>
                                <button type='reset' class="btn btn-block btn-lg btn-default"><i class="fa fa-filter"></i> Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12" id="main-essay-list">
                <button class="btn btn-default" id="toggleFilter"><i class="fa fa-bars"></i></button>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Series/Stage</th>
                                <th>Series Name / Stage Name</th>
                                <th>AR Level</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->type }}</td>
                                <td>{{ $book->type_name }}</td>
                                <td>{{ $book->ar_level }}</td>
                                <td>
                                    @if($book->status == "DONE")
                                        <span class='text-info'>DONE</span>
                                    @elseif($book->status == "Ongoing")
                                        <span class='text-warning'>Ongoing</span>
                                    @else
                                        <span class='text-dark'>Pending</span>
                                    @endif
                                    {{-- {!! $book->bookStudentStatus(auth()->user()->id) !!} --}}
                                </td>
                                <td>
                                    @if($book->last_modified)
                                    {{ date('h:iA Y-m-d', strtotime($book->last_modified)) }}
                                    @endif
                                </td>
                                <td class="text-right"><a class="btn btn-primary" href="{{ route('student.essay.show', $book->id) }}"> Show</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted text-center"> No Book found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                    <div class="text-right">
                        {{ $books->links() }}
                    </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            var filterOpen = false
            $('#toggleFilter').click(function(){
                if(filterOpen){
                    $('#side-filter').hide('fast')
                    setTimeout(function(){
                        $('#main-essay-list').removeClass('col-sm-9').addClass('col-sm-12')

                    },500)
                }else{
                    $('#main-essay-list').removeClass('col-sm-12').addClass('col-sm-9')
                    $('#side-filter').show('slow')
                }

                filterOpen = !filterOpen
            })
        })
    </script>
@endpush
