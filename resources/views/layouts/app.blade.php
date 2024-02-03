<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

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
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header text-center">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand text-center" href="#">
                        <img src="/images/logo.png" alt="" class="center-block">
                        <div class="text-center">English Essay Center</div>
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">ESSAY</a></li>
                        <li><a href="#">LIBRARY </a></li>
                        <li><a href="#">GRAMMAR</a></li>
                        <li><a href="#">ASSESSMENT</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @guest
                            <form class="navbar-form navbar-right">
                                <div class="form-group">
                                <input type="text" class="form-control" placeholder="username">
                                </div>
                                <div class="form-group">
                                <input type="text" class="form-control" placeholder="password">
                                </div>
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                    <ul class="dropdown-menu">
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
        <div class=" gap-bottom">
                <img src="/images/index/mainbanner.jpg" alt="" class="img-responsive">
        </div>

        <div class="text-center">
            <img src="/images/index/heading-text.png" style="width:250px" alt="">
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
