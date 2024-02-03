@extends('layouts.website')

@section('content')
        <div style="position:relative" class="text-center">
                <h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">GW Essay</h1>
                <img src="/images/index/banners/library.jpg" alt="">
        </div>
        <div class="container pt-5">
            <div class="row">
                <div class="col-sm-3">
                    <ul class="list-group">
                        @foreach($list as $list)
                            <li class="list-group-item">{{ $list['month'] }} </li>
                            @foreach($list['ranks'] as $ranking)
                                <a  class="list-group-item pl-5 @if(isset($month)) @if($month == $ranking['month'] && $rank == $ranking['rank']) active @endif @endif " href="{{ route('site.essay-rank') }}?month={{ $ranking['month'] }}&rank={{ $ranking['rank'] }}" class="d-block pl-3">
                                    <div class="row">
                                        <div class="col-xs-6">{{ $ranking['rank'] == 1 ? 'Champion' : 'Runner-up' }}</div>
                                        @if($ranking['student'])
                                            <div class="col-xs-6">
                                                {{ $ranking['student']->username }} ({{ makeStarInString($ranking['student']->name) }})
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-9">
                    @if(isset($activecomponent))
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
                        @foreach($activecomponent->inputs as $input)
                            @include('inputs.rank.' . strtolower(\Str::slug($input)), ['hasInput' => true])
                        @endforeach
                        <br>
                    @else
                        <h1 class="text-center text-muted mt-5">No items for this rank</h1>
                    @endif
                </div>
            </div>
        </div>
@endsection
