<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel = "icon" href="/images/index/icon.jpg" type = "image/x-icon">



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
      <div id="app">
            <nav class="navbar website-navbar">
                  <div class="container">
                  <!-- Desktop View, July 2, 2020 - Niel blanca -->
                  <div class="navbar-header text-center  hidden-sm visible-md visible-lg">
                        <button type="button" style="border:1px solid red;" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand text-center" href="/">
                              <img src="/images/index/logo.png" alt="" class="center-block  mw-100" style="width:200px">
                        </a>
                  </div>
                   <!-- Mobile View, July 2, 2020 - Niel blanca  -->
                  <div class="navbar-header hidden-md hidden-lg mb-3a">
                        <button type="button" class="navbar-toggle text-white mt-4 collapsed btn btn-primary" style="color: #fff;background-color: #204d74; border-color: #122b40;" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <i class="fa fa-align-justify"></i>
                        </button>
                        <a class="navbar-brand " href="/">
                              <img src="/images/index/logo.png" alt="logo" style="width:200px;" >
                        </a>
                  </div>

                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                              <li class="{{ back_end_active_menu('essay', 1, 'active') }} dropdown">
                                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">READ & ESSAY  <span class="caret"></span></a>

                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                          <li><a
                                                @auth
                                                      href="{{ route('student.essay.index')  }}"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth
                                                >
                                                Essay
                                                </a></li>
                                          <li><a
                                                @auth
                                                      href="{{ route('student.diary.index')  }}"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth
                                                >Diary Entry & Journal</a></li>
                                          
                                    </ul>
                              </li>
                              <li class="dropdown">
                                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">LESSON TABLE  <span class="caret"></a>

                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                          <li><a
                                                @auth
                                                      href="{{ route('student.essay.chart') }}?type=erp"
                                                      target="_blank"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth

                                                >Read</a>
                                          </li>
                                          <li><a
                                                @auth
                                                      href="{{ route('student.essay.chart') }}?type=asw"
                                                      target="_blank"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth

                                                >Essay
                                                </a>
                                          </li>
                                    </ul>
                              </li>
                              <li  class="dropdown">
                                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">LIBRARY <span class="caret"></a>
                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                          <li>
                                                <a
                                                @auth
                                                      href="{{ route('library.index') }}"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth

                                                >Library </a>
                                          </li>
                                          <li>
                                                <a
                                                @auth
                                                      href="{{ route('audiobook.index') }}"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth

                                                >Audio Book </a>
                                          </li>
                                          <li><a
                                                @auth
                                                      href="{{ route('student.recording.index')  }}"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth
                                                >Recording</a></li>
                                    </ul>
                              </li>
                              <li class="dropdown">
                                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">GRAMMAR <span class="caret"></a>

                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                          <li><a href="{{ route('student.quiz.index')  }}">GW Grammar Exercise</a></li>
                                          <li><a
                                                @auth
                                                      href="{{ route('student.puzzle.index') }}"
                                                @else
                                                      href="#"
                                                      onclick="alert('로그인 후 이용 가능합니다')"
                                                @endauth

                                                >Verb Puzzle(Past Tense)</a>
                                          </li>
                                    </ul>
                              </li>
                              <li><a href="#">ASSESSMENT</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                              @guest
                                    <form class="form-inline mt-3 hidden-sm visible-md visible-lg" method="POST"  action="{{ route('login') }}">
                                          <a href="{{ route('register') }}" class="btn btn-primary">회원가입</a>
                                          @csrf
                                          <div class="form-group">
                                                <input type="text" name="username" required class="form-control" placeholder="아이디" style="max-width: 95px;">
                                          </div>
                                          <div class="form-group">
                                                <input type="password" name="password"  required class="form-control" placeholder="비밀번호" style="max-width: 95px;">
                                          </div>
                                          <button type="submit" class="btn btn-primary">로그인</button>
                                   </form>
                                    <form class="hidden-md hidden-lg mt-2 p-2" method="POST"  action="{{ route('login') }}">
                                          @csrf
                                          <input type="text" name="username" value="{{ old('username') }}" required class="form-control mb-3" placeholder="아이디">

                                          <input type="password" name="password"  required class="form-control" placeholder="비밀번호">
                                          <div class="mt-3">
                                                <button type="submit" class="btn btn-primary">로그인</button>
                                                <a href="{{ route('register') }}" class="btn btn-primary">회원가입</a>
                                          </div>
                                   </form>
                              @else
                                    <li>
                                          @if(Auth::user()->type  == "student")
                                                <a  href="{{ route('student.dashboard.index') }}">
                                                      Dashboard
                                                </a>
                                          @else
                                                      <a  href="{{ route('back-end.dashboard.index') }}">
                                                      Dashboard
                                                </a>
                                          @endif
                                    </li>
                                    <li class="dropdown">

                                          <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }} ({{ Auth::user()->name }})  <span class="caret"></span></a>

                                          <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                <li>
                                                      <a  href="{{ route('logout') }}"
                                                      onclick="event.preventDefault();
                                                                        document.getElementById('logout-form').submit();">
                                                            {{ __('Logout') }}
                                                      </a>
                                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                      </form>
                                                </li>
                                          </ul>
                                    </li>
                              @endguest
                        </ul>
                  </div>
                  </div>
            </nav>

            @yield('content')

                  <div class="hidden-md hidden-lg">
                  		<div class="bg-gray">
	                        <div class="container pt-4 pb-5">
	                        <div class="row mb-2">
                                <div class="col-sm-12">
                                    <div class="pt-3 pb-3" style="font-size: 21px;">
                                        GW Edu.
                                    </div>
                                    <div>GW영어독서학원 (BRN. 820-90-00083) I GW영어논술연구소 (BRN. 229-37-00816)</div>
                                    <div>경기도 고양시 덕양구 동산2로1 현대프라자 2F</div>
                                    <div>대표 : 이상아 Email : {{  domainBranch()->email_address }} <br> Fax: {{  domainBranch()->fax_number }}</div>

                                </div>
                                <div class="col-sm-12">
                                    <Br>
                                    <span class="text-center">
                                        <div>상담문의</div>
                                        <h3 class='mt-0'>{{ domainBranch()->contact_number }}</h3>
                                            <div>월~금 13:30~19:00</div>
                                    </span>
                                </div>
	                        </div>
	                        <div class="text-center mt-3 pt-1">
	                              Copyright@2020 {{  domainBranch()->center_name }}
	                              <br>
	                              All rights reserved.

	                        </div>
	                        </div>
                  		</div>
                  </div>


            <footer>
            	<div class="hidden-sm visible-lg visible-md">
                  <div class="bg-gray" style="margin-bottom:1px">
                        <div class="container">
                              <a href="http://blog.naver.com/kswooribook" class='pull-right mt-2' target="_blank">
                              <img src="/images/index/blog.png"  alt="">
                              </a>
                              <div class="link-list">
                                    <a href="#">GW Education</a>
                                    <a href="#">GW영어독서학원</a>
                                    <a href="#">GW영어논술연구소</a>
                                    <a href="/policy">이용약관</a>
                                    <a href="/personal-information">개인정보취급방침</a>
                              </div>
                        </div>
                  </div>
                  <div class="bg-gray">
                        <div class="container pt-4 pb-5">
                        <div class="row mb-2">
                              <div class="col-sm-10">
                                    <div class="pt-3 pb-3">
                                         GW Edu.
                                    </div>
                                    <table>
                                          <tr>
                                                <td>GW영어독서학원 (BRN. 820-90-00083)  I   GW영어논술연구소 (BRN. 229-37-00816)</td>
                                                <td></td>
                                          </tr>
                                          <tr>
                                                <td>경기도 고양시 덕양구 동산2로1 현대프라자 2F</td>
                                                <td></td>
                                          </tr>
                                          <tr>
                                                <td>대표 : 이상아  Email : {{ domainBranch()->email_address }}   Fax : {{ domainBranch()->fax_number }}</td>
                                                <td></td>
                                          </tr>
                                    </table>
                              </div>
                              <div class="col-sm-2">
                                    <span class="pull-right">
                                    상담문의
                                    <h3 class='mt-0'>{{ domainBranch()->contact_number }}</h3>
                                    <div>월~금 13:30~19:00</div>
                                    </span>
                              </div>
                        </div>
                        <div class="text-center mt-3 pt-5">
                              Copyright@2021 {{ domainBranch()->center_name }} All rights reserved.
                              {{-- <br> v{{ getVersion() }} --}}
                        </div>
                        </div>
                  </div>
                  </div>
            </footer>
    </div>
          <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
      @if(Request::segment(2) != "register")
            @error('username')
                  <script>
                        alert('{{ $message }}')
                  </script>
            @enderror
      @endif
      @stack('scripts')
</body>
</html>
