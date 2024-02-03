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
                  <img src="/images/index/gwmain_1.jpg"  style="width:100%" alt="home-banner">
                </div>
                <div class="item"  style="padding-top:0px">
                     <a href="{{ route('about.index')}}">
                        <img src="/images/index/gwmain_2.jpg" style="width:100%" alt="about-banner">
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
                <a 
                    @auth
                            href="{{ route('student.essay.index')  }}"
                    @else
                            href="#"
                            onclick="alert('로그인 후 이용 가능합니다')"
                    @endauth 
                    >
                    <img src="/images/index/go-now.png" alt="">
                </a>
            </div>
            <div class="col-sm-3 col-xs-12 text-center gw-program-cards">
                <img src="/images/index/library.jpg" class='img-responsive center-block mb-3' alt="">
                <a 
                    @auth
                            href="{{ route('library.index') }}"
                    @else
                            href="#"
                            onclick="alert('로그인 후 이용 가능합니다')"
                    @endauth   
                >
                    <img src="/images/index/go-now.png" alt="">
                </a>
            </div>
            <div class="col-sm-3 col-xs-12 text-center gw-program-cards">
                <img src="/images/index/grammar.jpg" class='img-responsive center-block mb-3' alt="">
                <a 
                    @auth
                        href="{{ route('student.quiz.index') }}"
                    @else
                            href="#"
                            onclick="alert('로그인 후 이용 가능합니다')"
                    @endauth   
                >
                    <img src="/images/index/go-now.png" alt="">
                </a>
            </div>
            <div class="col-sm-3 col-xs-12 text-center gw-program-cards">
                <img src="/images/index/assessment.jpg" class='img-responsive center-block mb-3' alt="">
                <a href="#">
                    <img src="/images/index/go-now.png" alt="">
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
                <div class="col-sm-6 col-xs-12" style="position: relative; cursor:pointer" data-toggle="modal" data-target="#myModal">
                    @if($firstStudentRank && $firstStudentRank->student)
                        <div class="rank-box">
                            <div class="rank-1">{{ $firstStudentRank->student->username }}({{ makeStarInString($firstStudentRank->student->name) }})</div>
                            <div class="rank-2">{{ $secondStudentRank->student->username }}({{ makeStarInString($secondStudentRank->student->name) }})</div>
                        </div>
                    @endif
                    <img src="/images/index/gs.jpg" class='img-responsive center-block' alt="">
                </div>
                <div class="col-sm-6 col-xs-12">
                    <a href="{{ route('site.essay-rank') }}">
                        <img src="/images/index/ga.jpg" class='img-responsive center-block' alt="">
                    </a>
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
                        <div>월~금 13:30~19:00</div>
                        <div>카카오톡 문의 ID GW영어독서학원</div>
                        <div>블로그 http://blog.naver.com/kswooribook</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Student Ranking</h4>
            </div>
            <div class="modal-body">
                {{-- @foreach($studentRanks as $studentRank)
                    <div>
                        <h3 for="">{{ date('M, Y', strtotime($studentRank['month'])) }}</h3>
                        @foreach($studentRank['ranks'] as $rank)
                            <h5> &nbsp;&nbsp;&nbsp;&nbsp; {{ $rank['rank'] }}- {{ $rank['student'] }}</h5>
                        @endforeach
                    </div>
                @endforeach --}}

                @foreach($studentRanks as $rank)
                <div class="student-rank-list small">
                    <div class="date-div">
                        <div class="month">{{ date('M', strtotime($rank['month'])) }}</div>
                        <div class="year">{{ date('Y', strtotime($rank['month'])) }}</div>
                    </div>
                    <div class="details">
                        @foreach($rank['ranks'] as $student)
                            <h4>
                                @if($student['rank'] == 1)
                                    <img src="/images/index/first-medal.png" alt="">
                                @else
                                    <img src="/images/index/2nd-medal.png" alt="">
                                @endif
                                {{ $student['student'] }}
                            </h4>
                        @endforeach
                    </div>
                </div>
            @endforeach
            </div>
            <div class="modal-footer">
            <a href="{{ route('site.student-rank') }}" class="btn btn-primary">See More..</a>
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
                    <div>월~금 13:30~19:00</div>
                    <div>카카오톡 문의 ID GW영어독서학원</div>
                    <div>블로그 http://blog.naver.com/kswooribook</div>
                </div>
            </div>
        </div>
    </div>

    @if(count($banners))
        <!-- Modal -->
        <div class="modal fade " id="bannerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" style="font-size:24px;" data-dismiss="modal" aria-label="Close"><i class="fa fa-remove"></i></button>
                </div>
                <div class="modal-body">
                    @foreach($banners as $banner) 
                        @if($banner->link)
                            <a href="{{ $banner->link }}" target="_blank">
                        @endif

                        <img src="{{ $banner->banner_image }}" alt="" class="img img-responsive">
                        
                        @if($banner->link)
                            </a>
                        @endif
                    @endforeach
                    <input id="pop-upcheck" type="checkbox"> <label for="pop-upcheck"> 24시간 열지않기</label>
                </div>
          
                </div>
            </div>
        </div>
        
        @push('scripts')
            <script>
                $(document).ready(function(){
                    // alert(Math.round(new Date().getTime()))
                    if(!localStorage.getItem("hide-banner")){
                        if(localStorage.getItem("hide-banner-expiration") < new Date().getTime() ){
                            localStorage.removeItem("hide-banner");
                            localStorage.removeItem("hide-banner-expiration");
                            $('#bannerModal').modal('show')
                        }
                    }

                    setInterval(function(){
                        $('#timein').html(new Date().getTime())
                            if(localStorage.getItem("hide-banner")){
                                if(localStorage.getItem("hide-banner-expiration") <= new Date().getTime() ){
                                    localStorage.removeItem("hide-banner");
                                    localStorage.removeItem("hide-banner-expiration");
                                }
                            }
                    }, 100)

                    $("#pop-upcheck").change(function() {
                        if(this.checked) {
                            var time = Math.round(new Date().getTime() + 60 * 60 * 24 * 1000);
                            localStorage.setItem("hide-banner", true);
                            localStorage.setItem("hide-banner-expiration", time);
                        }else{
                            localStorage.removeItem("hide-banner");
                            localStorage.removeItem("hide-banner-expiration");
                        }
                    });
                })
            </script>
        @endpush
    @endif
  
@endsection

@push('scripts')
    @if($require_login)
            <script>
                alert(" 관리자에게 수강상태 확인요청 바랍니다")
            </script>
    @endif
@endpush