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
    <link href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/js/layx/layx.min.css') }}">
    @yield('css')
</head>
<body>
    <div id="app">
        @include('components.frontend.header')
        @yield('content')
    </div>

    @include(config('meedu.advance.layout_footer'))
    <script src="{{ mix('js/frontend.js') }}"></script>
    <script src="{{ asset('js/layx/layx.min.js') }}"></script>
    <script src="{{ asset('js/echo.min.js') }}"></script>
    <script>
        echo.init({
            offset: 100,
            throttle: 250,
            unload: false,
            callback: function (element, op) {
                //
            }
        });

        // 消息提示
        @if(get_first_flash('success'))
        layx.msg("{{get_first_flash('success')}}",{dialogIcon:'success'});
        @endif
        @if(get_first_flash('warning'))
        layx.msg("{{get_first_flash('warning')}}",{dialogIcon:'warn'});
        @endif
        @if(get_first_flash('error'))
        layx.msg("{{get_first_flash('error')}}",{dialogIcon:'error'});
        @endif
    </script>
    @yield('js')
    <div style="display:none">{!! config('meedu.system.js') !!}</div>
</body>
</html>
