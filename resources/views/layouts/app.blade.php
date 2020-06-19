<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- User ID -->
    <meta name="user-id" content={{ optional(Auth::user())->id }}>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ asset('css/nucleo.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('top')
</head>

<body>
    <div id="app">
        @auth
            @include('layouts.partials.sidebar')
        @endauth

        <div class="main-content" id="panel">
            @auth
                @include('layouts.partials.top-nav')
            @endauth
            @yield('content')
        </div>

        @yield('modal')
    </div>
</body>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@include('layouts.partials._notify')
@stack('bottom')
</html>