<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{$keywords ?? ''}}">
    <meta name="description" content="{{$description ?? ''}}">
    <title>{{Auth::check() ? Auth::user()->nick_name.' - ' : ''}}{{$title ?? 'MeEdu'}}</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_diy.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
    <div id="app">
        @include('components.frontend.header')
        @yield('content')
    </div>

    @include('components.frontend.footer')
    <script src="https://cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/echo.js/1.7.3/echo.min.js"></script>
    <script>
        echo.init({
            offset: 100,
            throttle: 250,
            unload: false,
            callback: function (element, op) {
                //
            }
        });
    </script>
    @yield('js')
</body>
</html>
