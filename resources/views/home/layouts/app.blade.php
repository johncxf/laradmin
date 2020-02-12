<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- Font Awesome4.7 Icons -->
    <link rel="stylesheet" href="{{asset('font/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- home.css -->
    <link rel="stylesheet" href="{{asset('css/home/home.css')}}">
    @yield('heads')
    @yield('styles')
</head>
<body>
    <div id="app">
        {{--顶部导航--}}
        @include('home.layouts.navbar')
        {{--主体部分--}}
        <main class="py-4">
            @yield('content')
        </main>

    </div>
<!-- jQuery v3.4.1-->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<!-- home.js -->
@yield('scripts')
</body>
</html>
