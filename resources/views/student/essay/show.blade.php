@extends("student.includes.layouts.main")  
@section('page-title', 'Book: '. $book->title . (isset($activecomponent) ? " @ " . $activecomponent->name : ''))
@section('content')
    <div class="row">
        <div class="col-sm-3 hidden-print">
            <br>
            <ul class="list-group ">
                <div style='margin-bottom:5px;' class="text-right" hidden>
                    <button class="btn btn-primary" onclick="window.open('{{ route('student.essay.print', $book->id ) }}' ,'_blank', 'location=yes,height=570,width=980,scrollbars=yes,status=yes')"><i class="fa fa-print"></i> Print</button>
                </div>
                @foreach($components as $component)
                    <li class="list-group-item">
                        <h4>
                            {{ $component->name }}
                        </h4>
                            <ul class="list-group">
                                @foreach($component->children()->orderBy("order")->get() as $children)
                                    <li class="list-group-item">
                                        <a type="button" role="button" data-toggle="collapse" data-target="#collapse-{{ $children->id }}" aria-expanded="false" aria-controls="collapse-{{ $children->id }}" >
                                            {{ $children->name }}
                                        </a>
                                    </li>
                                    <div class="list-group list-group-div collapse" id='collapse-{{ $children->id }}'>
                                        @foreach($children->children()->orderBy('order')->get() as $grandchildren)
                                            <a href="{{ route('student.essay.show', $book->id)}}?component={{$grandchildren->id}}" class="list-group-item {{ Request::get('component') == $grandchildren->id ? 'active' : '' }}" @if(Request::get('component') == $grandchildren->id) id="active-component" @endif >
                                                <!-- <span class="badge">01 / 03 / 2020 </span> -->
                                                <small>
                                                    {{ $grandchildren->name }}
                                                </small>
                                                @if($grandchildren->writings()->where('student', auth()->user()->id)->where('book_id', $book->id)->count())
                                                    <div class='text-right'>
                                                        <span class="custom-badge">{{ $grandchildren->writings()->where('student', auth()->user()->id)->where('book_id', $book->id)->orderBy('updated_at', 'DESC')->first()->updated_at->format('d/m/y') }}</span>
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
                <a href="{{ route('student.essay.print', $book->id) }}" target="_blank" class="btn btn-md btn-primary"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="box">
                <div class="header-title  hidden-print">
                    <div class="left-buttons pull-right hidden-print">
                        <button  onclick="window.print()"  class='btn btn-primary hidden-print'><i class="fa fa-print"></i> Print</button>
                        <a href="{{ route('student.essay.index') }}"  class='btn btn-primary hidden-print'><i class="fa fa-ban"></i> Back</a>
                    </div>
                    <h1>Essay</h1>
                    <div class="tag-line">
                        영어 논술
                    </div>
                </div>
                <div class="box-content">
                    @include('student.includes.alerts.message')
                    @if(Request::get('component'))
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
                        <form action="{{ route('student.writing.store') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $activecomponent->id }}" name="component_id">
                            <input type="hidden" value="{{ $book->id }}" name="book_id">
                            @foreach($activecomponent->inputs as $input)
                                @include('inputs.' . strtolower(\Str::slug($input)), ['hasInput' => true])
                            @endforeach
                            <br>
                            <div class="text-right hidden-print">
                                <button class="btn btn-warning btn-lg" type="submit"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </form>  
                        <component-comment isteacher="0" bookid="{{ $book->id }}" componentid="{{ $activecomponent->id }}" studentid="{{ auth()->user()->id }}" ></component-comment>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(Session::has('message'))   
        <!-- Modal -->
        <div class="modal fade" id="pop-up-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <br>
                    <div class="">
                        <strong>
                            {{ Session::get('message') }}
                        </strong>
                    </div>
                    <br>
                    <br>
                    <button type="button" class="btn btn-default" data-dismiss="modal">okay</button>
                </div>
            </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#active-component').closest('.collapse').addClass('in')
            $('#pop-up-modal').modal('show')
        })
    </script>
@endpush
