@extends("student.includes.layouts.main")  
@section('content')
    <div class="container">
        <div class="">
            <a href="{{ route('student.recording.create') }}" class="btn btn-warning btn-md pull-right"><i class="fa fa-plus"></i> Add New</a>
            <h2>Recordings</h2>
        </div>
        <div class="recordings">
            @foreach($recordings as $recording)
                <div class="flex center-items align-self-center @if(Request::get('recording') == $recording->id) active @endif">
                    <a href="{{ route('student.recording.show',$recording->id) }}">
                        <div class="icon"><i class="fa fa-play"></i></div>
                            <a href="{{ route('student.recording.show',$recording->id) }}" > 
                            {{ $recording->title }}
                        </a>
                    </a>
                    <div class="flex-1 info">
                        <div class="date" style="margin-top: -10px;">
                            <small>
                                {{-- <span class="item">
                                    <i class="fa fa-calendar"></i> {{ $recording->created_at->format('Y-m-d H:i') }}
                                </span> --}}
                                <span class="item">
                                    <a href="#" class="btn p-1" onclick="if(confirm('Are you sure to delete?')){ $('#delete-{{ $recording->id }}').submit() }" style="color: red;">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <form id="delete-{{ $recording->id }}" action="{{ route('student.recording.destroy', $recording->id) }}" method="POST">@csrf @method('DELETE')</form>
                                </span>
                            </small>
                        </div>
                        <br>
                            
                    </div>
                </div>
            @endforeach
            {{ $recordings->appends(['recording'=> Request::get('recording')])->links() }}
        </div>
    </div>
@endsection