@extends('layouts.website')

@section('content')
<div style="position:relative" class="text-center">
      <h1 class="text-center tex-white" style="position: absolute; top:40%; left:43%; color:#fff; font-size:48px">{{ Request::get('type') == 'grammar' ? 'GW문법' : '공지사항'   }}</h1>
      <img src="/images/bg/grammer.jpeg" alt="">
</div>
      <div class="container mb-5">
            <div class="row mt-3 mb-3" style="min-height: 250px;">
                  <div class="col-sm-10 col-sm-offset-1">
                        @foreach($notices as $notice)
                              <div class="pt-4 pb-4 " style="border-bottom:1px dotted #ccc;" >
                                    <a href="{{ route('notice.show', $notice->id) }}?type={{ $notice->type }}" class="text-dark h3 text-primary">
                                          {{ Str::limit($notice->title, 50, '...') }}
                                          <span class="pull-right text-muted h5">{{ $notice->created_at->format("Y-m-d") }}</span>
                                    </a>
                              </div>
                        @endforeach
                        <div class="notice-body">
                              {{ $notices->appends(['type' => Request::get('type') ?? 'notice'])->links() }}
                        </div>
                  </div>
            </div>
           
      </div>
@endsection
