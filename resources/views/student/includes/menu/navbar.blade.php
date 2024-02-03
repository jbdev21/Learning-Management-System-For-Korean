<nav class="navbar navbar-default nav-bar">
    <div class="container-fluid">
        <div class="navbar-header hidden-md hidden-lg mb-3a">
            <button type="button" class="navbar-toggle text-white mt-4 collapsed btn btn-primary" style="color: #fff;background-color: #204d74; border-color: #122b40;" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-align-justify"></i>
            </button>
        </div>

        <div class="navbar-collapse collapse" id="main-menu">
            <ul class="nav navbar-nav main-navbar">
                <li ><a href="/">HOME</a></li>
                <li class="{{ back_end_active_menu('essay', 1, 'active') }} dropdown">
                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">ESSAY  <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                       <li><a href="{{ route('student.essay.index')  }}">Writing</a></li>
                       <li><a href="{{ route('student.diary.index')  }}">Diary Entry & Journal</a></li>
                       
                    </ul>
                </li>
                <li class="dropdown hidden-sm visible-md visible-lg">
                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">LESSON TABLE <span class="caret"></a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                       <li><a href="{{ route('student.essay.chart') }}?type=erp" target="_blank">LESSON TABLE / E.R.P</a></li>
                       <li><a href="{{ route('student.essay.chart') }}?type=asw" target="_blank">LESSON TABLE / A.S.W</a></li>
                    </ul>
                </li>
                {{-- <li><a href="{{ route('student.puzzle.index') }}">Puzzle</a></li> --}}
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
                <li class="dropdown">
                    <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">GRAMMAR <span class="caret"></a>
                     
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                       <li><a href="{{ route('student.quiz.index')  }}">GW Grammar Exercise</a></li>
                       <li><a href="{{ route('student.puzzle.index') }}">Verb Puzzle(Past Tense)</a></li>
                    </ul>
                </li>
                {{-- <li class="{{ back_end_active_menu('quiz', 1, 'active') }}"><a href="{{ route('notice.index', ['type' => 'grammar']) }}">QUIZE</a></li> --}}
                <li><a href="#">ASSESSMENT</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right ">

                <notification-component listurl="{{ route('student.notification.index') }}"></notification-component>

                <li class="dropdown profile-dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                        <img src="{{ auth()->user()->avatar }}" alt="">
                        {{ auth()->user()->username }}({{ auth()->user()->name }})
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('student.profile.index') }}">Profile</a></li>
                        <li><a href="{{ route('student.profile.changepassword') }}">Change Password</a></li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="#" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">Sign out</a>
                        </li>
                        
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
