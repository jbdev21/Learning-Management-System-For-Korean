<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title', config('app.name'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
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
    <div id='app'>
        <div class="container-fluid">
            @yield('content')
        </div>

    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/student.js') }}"></script>
    @stack('scripts')
        @show
</body>

</html>