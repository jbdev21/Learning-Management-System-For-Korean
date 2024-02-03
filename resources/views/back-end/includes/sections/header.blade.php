<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel = "icon" href="/images/index/icon.jpg" type = "image/x-icon">

    <title>@yield('page-title') | {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    @if(Auth::check())
        <script>
            loggedUser = {!! auth::user()  !!}
        </script>
    @endif
    <!-- Styles -->
    <link href="{{ asset('css/back-end.css') }}" rel="stylesheet">
    @stack('styles')
        @show
</head>
<body class="hold-transition skin-black-light sidebar-mini">
    <div class="wrapper" id="app"> 