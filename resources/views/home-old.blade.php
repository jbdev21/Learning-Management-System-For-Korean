@extends('layouts.website')
@section('content')
   {{--  <div class=" gap-bottom">
               <img src="/images/index/mainbanner.jpg" alt="" style="width:100%">
    </div> --}}
      <!-- Desktop View, July 2, 2020 - Niel blanca -->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
              </ol>

              <div class="carousel-inner" role="listbox">
                <div class="item active" style="padding-top:0px">
                  <img src="/images/index/gwmain_1.jpg" class="img img-responsive" alt="home-banner">
                </div>
                <div class="item"  style="padding-top:0px">
                     <a href="{{ route('about.index')}}">
                        <img src="/images/index/gwmain_2.jpg" class="img img-responsive" alt="about-banner">
                    </a>
                </div>
              </div>

              <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
        </div>  

    <div class="text-center pb-5 pt-5 mt-5 mb-5">
        <img src="/images/index/heading-text.png" style="width:250px;" alt="">
        <br>
        <br>
        <div class="container">
            <div class="col-sm-3 col-xs-12 text-center gw-program-cards">
                <img src="/images/index/essay.jpg" class='img-responsive center-block mb-3' alt="">
                <a href="#">
                    <img src="/images/index/go-now.png" alt="">
                </a>
            </div>
            <div class="col-sm-3 col-xs-12 text-center gw-program-cards">
                <img src="/images/index/library.jpg" class='img-responsive center-block mb-3' alt="">
                <a href="#">
                    <img src="/images/index/go-now-outline.png" alt="">
                </a>
            </div>
            <div class="col-sm-3 col-xs-12 text-center gw-program-cards">
                <img src="/images/index/grammar.jpg" class='img-responsive center-block mb-3' alt="">
                <a href="{{ route('notice.index', ['type' => 'grammar']) }}">
                    <img src="/images/index/go-now-outline.png" alt="">
                </a>
            </div>
            <div class="col-sm-3 col-xs-12 text-center gw-program-cards">
                <img src="/images/index/assessment.jpg" class='img-responsive center-block mb-3' alt="">
                <a href="#">
                    <img src="/images/index/go-now-outline.png" alt="">
                </a>
            </div>
        </div>
    </div>
        

    <div>
        <a href="http://gwenglishacademy.com/about/photo_2">
            <img src="/images/index/banner.jpg"  style="width:100%"  alt="">
        </a>
    </div>


    <div class="bg-default pt-5 pb-4" style="background-color:#eaeaea">
        <div class="container pb-5 pt-5 mb-5 pb-5 pt-5">
            <img src="/images/index/gw-student-heading.png" style="width:250px;"  class="center-block mb-5" alt="">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <img src="/images/index/gs.jpg" class='img-responsive center-block' alt="">
                </div>
                <div class="col-sm-6 col-xs-12">
                    <img src="/images/index/ga.jpg" class='img-responsive center-block' alt="">
                </div>
            </div>
        </div>
    </div>

  <!-- Desktop View, July 2, 2020 - Niel blanca -->
    <div class="pt-5 pb-5 hidden-sm visible-md visible-lg">
        <div class="container">
            <div class="flex pt-5 pb-5">
                <div class="col">
                    <div class="box-header mb-2">
                        공지사항
                        <a href="{{ route('notice.index', ['type' => 'notice']) }}" class="pull-right"><i class="fa fa-plus"></i></a>                        
                    </div>
                    @foreach($notices as $notice)
                        <div class="pt-2 pb-2">
                            <a href="{{ route('notice.show', $notice->id) }}" class="text-dark">
                                {{ Str::limit($notice->title, 25, '...') }}
                                <span class="pull-right text-muted">{{ $notice->created_at->format("Y-m-d") }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="col">
                    <div class="box-header">
                        GW문법
                        <a href="{{ route('notice.index', ['type' => 'grammar']) }}" class="pull-right"><i class="fa fa-plus"></i></a>                     
                    </div>
                       @foreach($grammars as $grammar)
                        <div class="pt-2 pb-2">
                            <a href="{{ route('notice.show', $grammar->id) }}" class="text-dark">
                                {{ Str::limit($grammar->title, 25, '...') }}
                                <span class="pull-right text-muted">{{ $grammar->created_at->format("Y-m-d") }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="col">
                    <div class="box-header">상담.문의</div>
                    <div class="text-center p-4 pt-5 pb-5">
                        <img src="/images/index/cs.png" alt="">
                        <h3>02-371-1500</h3>
                        <div>월~금 13:30~21:00 / 토 10:00~15:00</div>
                        <div>카카오톡 문의 ID GW영어독서학원</div>
                        <div>블로그 http://blog.naver.com/kswooribook</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- Mobile View, July 2, 2020 - Niel blanca -->
     <div class="pt-5 pb-5 vissible-sm hidden-md hidden-lg">
        <div class="container">
            <div class="col-sm-12 col-xs-12" style="border: 1px solid;">
                <div class="col">
                    <div class="box-header">
                        공지사항
                        <a href="{{ route('notice.index', ['type' => 'notice']) }}" class="pull-right"><i class="fa fa-plus"></i></a>                        
                    </div>
                    @foreach($notices as $notice)
                        <div>
                            <a href="{{ route('notice.show', $notice->id) }}" class="text-dark">
                                {{ Str::limit($notice->title, 25, '...') }}
                                <span class="pull-right text-muted">{{ $notice->created_at->format("Y-m-d") }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <br>
                <br>
            </div>

            <div class="col-sm-12 col-xs-12" style="border: 1px solid;">
                <div class="box-header">
                    GW문법
                    <a href="{{ route('notice.index', ['type' => 'grammar']) }}" class="pull-right"><i class="fa fa-plus"></i></a>                     
                </div>
                   @foreach($grammars as $grammar)
                    <div>
                        <a href="{{ route('notice.show', $grammar->id) }}" class="text-dark">
                            {{ Str::limit($grammar->title, 25, '...') }}
                            <span class="pull-right text-muted">{{ $grammar->created_at->format("Y-m-d") }}</span>
                        </a>
                    </div>
                @endforeach
                <br>
                <br>
            </div>

            <div class="col-sm-12 col-xs-12" style="border: 1px solid;">
                <div class="box-header text-center">상담.문의</div>
                <div class="text-center p-4 pt-5 pb-5">
                    <img src="/images/index/cs.png" alt="">
                    <h3>02-371-1500</h3>
                    <div>월~금 13:30~21:00 / 토 10:00~15:00</div>
                    <div>카카오톡 문의 ID GW영어독서학원</div>
                    <div>블로그 http://blog.naver.com/kswooribook</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if($require_login)
            <script>
                alert(" Please login to continue")
            </script>
    @endif
@endpush