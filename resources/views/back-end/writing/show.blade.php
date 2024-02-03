@extends("back-end.includes.layouts.main")

@section('page-title', 'Book: '. $book->title . (isset($activecomponent) ? " @ " . $activecomponent->name : ''))

@section('content')
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Writings</h3>
        </div>
        <div class="box-body">
               <div class="row">
                <div class="col-sm-4">
                    <div class="p-5">
                        <scoring-range default="{{ $bookScore->rating ?? 0 }}"
                            label='Book Score'
                            uri="{{ route('back-end.writing.book.sendscore') }}"
                            student="{{ $student->id }}"
                            book="{{ $book->id }}"
                        ></scoring-range>
                    </div>
                    <ul class="list-group">
                    @foreach($components as $component)
                        <li class="list-group-item">
                            <h4>
                                {{ $component->name }}
                            </h4>
                            <ul class="list-group">
                                @foreach($component->children()->orderBy("order")->get() as $children)
                                    <li class="list-group-item" style="border-radius: none">
                                        <a type="button" role="button" data-toggle="collapse" data-target="#collapse-{{ $children->id }}" aria-expanded="false" aria-controls="collapse-{{ $children->id }}" >
                                            {{ $children->name }}
                                        </a>
                                    </li>
                                    <div class="list-group list-group-div collapse " style="border-radius: none" id='collapse-{{ $children->id }}'>
                                        @foreach($children->children()->orderBy('order')->get() as $grandchildren)
                                            <a style="border-radius: none" href="{{ route('back-end.writing.show', ['component' => $grandchildren->id, 'book' => $book->id, 'student' => $student->id ])}}" class="list-group-item {{ Request::get('component') == $grandchildren->id ? 'active' : '' }}" @if(Request::get('component') == $grandchildren->id) id="active-component" @endif >
                                                <!-- <span class="badge">01 / 03 / 2020 </span> -->
                                                <small style="padding-left:10px">
                                                    &nbsp; {{ $grandchildren->name }}
                                                </small>
                                                @if($grandchildren->writings()->where('student', $student->id)->where('book_id', $book->id)->count())
                                                    <div class='text-right'>
                                                        <span class="custom-badge">{{ $grandchildren->writings()->where('student', $student->id)->where('book_id', $book->id)->orderBy('updated_at', 'DESC')->first()->updated_at->format('Y-m-d') }}</span>
                                                    </div>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
                <div class="text-right">
                    <a href="{{ route('back-end.writing.print', [$book->id, $student->id]) }}" target="_blank" class="btn btn-md btn-primary"><i class="fa fa-print"></i> Print</a>
                </div>
                </div>
                <div class="col-sm-8">
                    @if(Request::get('component'))
                        <div class="text-right pull-right">
                            <div>
                                <scoring-range
                                    uri='{{ route('back-end.writing.component.sendscore') }}'
                                    student="{{ $student->id }}"
                                    component="{{ $activecomponent->id }}"
                                    book="{{ $book->id }}"
                                    default="{{ $score->rating ?? 0  }}"
                                    label='Component Score'
                                    ></scoring-range>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="text-center">
                            <h1 style="color:#20BACF">{{ $book->title }}</h1>
                            Series/Stage: {{ $book->type_name }} &nbsp;&nbsp;&nbsp; AR Level: {{ $book->ar_level }}
                        </div>
                        <div class="text-center">
                            <h3>
                                {{ $activecomponent->parent->name }}
                            </h3>
                            <div class="text-muted">
                                {{ $activecomponent->name }}
                                <br>
                                </div>
                        </div>
                        <hr>
                        <form action="{{ route('back-end.writing.store') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ Request::get('student') }}" name="student">
                            <input type="hidden" value="{{ $activecomponent->id }}" name="component_id">
                            <input type="hidden" value="{{ $book->id }}" name="book_id">
                            @foreach($activecomponent->inputs as $input)
                                @include('inputs.' . strtolower(\Str::slug($input)))
                            @endforeach
                            <div class="text-right">
                                <button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>
                        <component-comment isteacher="1" bookid="{{ $book->id }}" componentid="{{ $activecomponent->id }}" studentid="{{ $student->id }}" ></component-comment>
                    @endif
                </div>
            </div>
        </div>
      </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#active-component').closest('.collapse').addClass('in')
        })
    </script>
@endpush
