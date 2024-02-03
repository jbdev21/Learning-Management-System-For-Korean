@extends("back-end.includes.layouts.main")  

@section('page-title', 'Recordings')

@section('content')
      <div class="box">
            <div class="box-header with-border">
            <h3 class="box-title">Recording</h3>
            </div>
                  <div class="box-body">
                        <h2 class="mt-0">
                              {{ $student->username }} ({{ $student->name }})
                        </h2>
                        <div class="row ">
                              <div class="col-sm-4">
                                    <div class="recordings">
                                          @foreach($recordings as $recording)
                                                <div class="flex center-items align-self-center @if($activeRecord->id == $recording->id) active @endif">
                                                      <a href="{{ route('back-end.recording.show', $student->id) }}?audio={{ $recording->id }}">
                                                            <div class="icon"><i class="fa fa-play"></i></div>
                                                      </a>
                                                      <div class="flex-1 info">
                                                            <div class="date" style="margin-top: -10px;">
                                                                  <span class="item">
                                                                  <i class="fa fa-calendar" style="margin-left: -550rm;"></i> {{ $recording->created_at->format('Y-m-d H:i') }}
                                                                  </span>
                                                                  <span class="item">
                                                                  <a href="#" onclick="if(confirm('Are you sure to delete?')){ $('#delete-{{ $recording->id }}').submit() }" style="color: red;">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                  </a>
                                                                  <form id="delete-{{ $recording->id }}" action="{{ route('back-end.recording.destroy', $recording->id) }}" method="POST">@csrf @method('DELETE')</form>
                                                                  </span>
                                                            </div>
                                                            <br>
                                                            <div>
                                                                  <a href="{{ route('back-end.recording.show', $student->id) }}?audio={{ $recording->id }}">
                                                                  {{ $recording->title }}
                                                                  </a>

                                                                  {{-- <sub>
                                                                  <i>{{ Str::limit(strip_tags($recording->script), 80) }} </i>
                                                                  </sub> --}}
                                                            </div>
                                                      </div>
                                                </div>
                                          @endforeach
                                    </div>
                                    {{ $recordings->appends(['recording'=> Request::get('recording')])->links() }}
                              </div>
                              @if($activeRecord)
                                    <div class="col-xs-8">
                                          <div style="margin:0px;" class="p-3">
                                                <div class="text-right">
                                                      <div class="mb-4">
                                                            <a href="{{ route('back-end.recording.index') }}" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Back</a>
                                                      </div>
                                                      <audio controlsList="download" preload="auto" src="{{ Storage::url($activeRecord->recording) }}" controls></audio>
                                                      <a href="{{ Storage::url($activeRecord->recording) }}" class="btn btn-default btn-bg" style="margin-top:-45px" download><i class="fa fa-download"></i> Download</a>
                                                </div>
                                                {{-- </div> --}}
                                                <h1 style="margin:0px;">{{ $activeRecord->title }}</h1>
                                                <small>- <i class="fa fa-calendar"></i> {{ $activeRecord->created_at->format('Y-m-d H:i') }}</small>
                                                <br>
                                                <br>
                                                {!! nl2br($activeRecord->script) !!}
                                          </div>
                                          <br>
                                           <comment-component item="{{ $activeRecord->id }}" model="recording"></comment-component>
                                    </div>
                              @endif
                        </div>
                  </div>
            </div>
      </div>
@endsection

