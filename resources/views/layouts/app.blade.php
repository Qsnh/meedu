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
    <script src="{{ mix('js/frontend.js') }}"></script>
    @yield('css')
</head>
<body>
    <div id="app">
        @include('components.frontend.header')
        @yield('content')
    </div>

    @include(config('meedu.advance.layout_footer'))
    <script src="{{ asset('js/echo.min.js') }}"></script>
    <script crossorigin="anonymous" integrity="sha384-RIQuldGV8mnjGdob13cay/K1AJa+LR7VKHqSXrrB5DPGryn4pMUXRLh92Ev8KlGF" src="https://lib.baomitu.com/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        echo.init({
            offset: 100,
            throttle: 250,
            unload: false
        });

        // 消息提示
        @if(get_first_flash('success'))
        swal("成功", "{{get_first_flash('success')}}", "success");
        @endif
        @if(get_first_flash('warning'))
        swal("警告", "{{get_first_flash('warning')}}", "warning");
        @endif
        @if(get_first_flash('error'))
        swal("错误", "{{get_first_flash('error')}}", "error");
        @endif
    </script>
    @yield('js')
    <div style="display:none">{!! config('meedu.system.js') !!}</div>
</body>
</html>
