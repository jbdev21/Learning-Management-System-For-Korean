@extends('layouts.website')
@section('content')
<div style="position:relative" class="text-center">
      <h1 class="text-center text-white" style="position: absolute; top:10%; left:43%; color:#fff; font-size:3em">{{ $notice->type == 'notice' ? '공지사항' : 'GW문법' }}</h1>
      <img src="/images/bg/grammer.jpeg" class="img-responsive img" alt="">
</div>
<div class="container mb-5 pb-5">
      <div class="mb-4">
            <h2 class="mb-0">{{ $notice->title }}</h2>
            <span class="mr-3"><i class="fa fa-user"></i> {{ $notice->user->name }}</span>
            <i class="fa fa-calendar"></i> {{ $notice->created_at->format('M d, Y') }}
      </div>
      <div class="mt-5 notice-body" style="font-size:22px;">
      {!! $notice->content  !!}
      </div>
      <div class="text-right mt-5 mb-2">
            <div class="btn-group btn" role="group" aria-label="...">
                  @if($previous)
                        <a href="{{ route('notice.show', $previous->id) }}" class='btn btn-primary p-4'>
                              <i class="fa fa-arrow-left pull-left mt-1"></i> 이전
                        </a>
                  @endif
                  <a href="{{ route('notice.index', ['type' => $notice->type]) }}" class='btn btn-primary p-4'>
                        <i class="fa fa-list"></i>  목록 
                  </a>
                  @if($next)
                        <a href="{{ route('notice.show', $next->id) }}" class='btn btn-primary p-4'> 
                              다음
                              <i class="fa fa-arrow-right pull-right mt-1"></i>
                        </a>
                  @endif
            </div>
      </div>
</div>
@endsection

@push('scripts')
      <script>
            $('.notice-body img').each(function(){
                  $(this).addClass('img-responsive');
            })
      </script>
@endpush