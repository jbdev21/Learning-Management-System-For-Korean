<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>@yield('page-title', config('app.name'))</title>

    <!-- Scripts -->
     <link href="{{ asset('css/student.css') }}" rel="stylesheet">
    @if(Auth::check())
        <script>
            loggedUser = {!! auth::user()  !!}
        </script>
    @endif
    @stack('styles')
        @show
</head>
<body>
      <div id="app">
            <nav class="navbar website-navbar">
                  <div class="container">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header text-center">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand text-center" href="/">
                              <img src="/images/index/logo.png" alt="" class="center-block mt-5 mw-100" style="width:200px">
                        </a>
                  </div>

                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                              <li class="{{ back_end_active_menu('essay', 1, 'active') }} dropdown">
                                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ESSAY  <span class="caret"></span></a>

                                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                                          <li><a href="{{ route('student.essay.index')  }}">Writing</a></li>
                                          <li><a href="{{ route('student.diary.index')  }}">Diary Entry & Journal</a></li>
                                          
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
                                          <li><a href="{{ route('student.recording.index')  }}">Recording</a></li>
                                    </ul>  
                              </li>
                              <li><a href="#">GRAMMAR</a></li>
                              <li><a href="#">ASSESSMENT</a></li>
                              <li><a href="{{ route('student.quiz.index')  }}">QUIZ</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                              @guest
                              <form class="navbar-form navbar-right" method="POST"  action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                          <a href="{{ route('register') }}" class="btn btn-primary">회원가입</a>
                                    </div>
                                    <div class="form-group">
                                    <input type="text" name="username" required class="form-control" placeholder="아이디">
                                    </div>
                                    <div class="form-group">
                                    <input type="password" name="password"  required class="form-control" placeholder="비밀번호">
                                    </div>
                                    <button type="submit" class="btn btn-primary">로그인</button>
                              </form>
                              @else
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
                              @endguest
                  </ul>
                  </div>
                  </div>
            </nav>
            <img src="/images/index/my-page.jpg" alt="">
            <div class="container-fluid" >
            @yield('content')
            </div>
            <footer>
                  <div class="bg-gray" style="margin-bottom:1px">
                        <div class="container">
                              <a href="http://blog.naver.com/kswooribook" class='pull-right mt-2' target="_blank">
                              <img src="/images/index/blog.png"  alt="">
                              </a>
                              <div class="link-list">
                                    <a href="#">GW Education</a>
                                    <a href="#">GW영어독서학원</a>
                                    <a href="#">GW영어논술센터</a>
                                    <a href="#">이용약관</a>
                                    <a href="#">개인정보취급방침</a>
                              </div>
                        </div>
                  </div>
                  <div class="bg-gray">
                        <div class="container pt-4 pb-5">
                        <div class="row mb-2">
                              <div class="col-sm-10">
                                    <div class="pt-3 pb-3">
                                          GW영어독서학원
                                    </div>
                                    <table>
                                    <tr>
                                          <td>센터 </td>
                                          <td>: 경기도 고양시 덕양구 동산2로 1 현대프라자 2층 14</td>
                                    </tr>
                                    <tr>
                                          <td>주소  </td>
                                          <td>: 경기도 고양시 덕양구 화정동 동양트레빌 1621호</td>
                                    </tr>
                                    <tr>
                                          <td>대표 </td>
                                          <td>: 김용환 Email : kswooribook@naver.com 사업자등록번호 : 820-90-00083 Fax 02-371-1501</td>
                                    </tr>
                                    </table>
                              </div>
                              <div class="col-sm-2">
                                    <span class="pull-right">
                                    상담문의
                                    <h3 class='mt-0'>02-371-1500</h3>
                                          <div>월~금 13:30~21:00</div>
                                          <div>토  10:00~15:00</div>
                                    </span>
                              </div>
                        </div>
                        <div class="text-center mt-3 pt-5">
                              Copyright{{ date('@Y')}} GW ENGLISH ESSAY CENTER All rights reserved.
                              <br> v{{ getVersion() }}
                        </div>
                        </div>
                  </div>
            </footer>
      </div>
      @if(Request::segment(2) != "register")
            @error('username')
                  <script>
                        alert('{{ $message }}')
                  </script>
            @enderror
      @endif
          <!-- Scripts -->
    <script src="{{ asset('js/student.js') }}"></script>
    @stack('scripts')
        @show
</body>
</html>