<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-login-status" content="{{ $user ? 1 : 0 }}">
    <meta name="keywords" content="{{$keywords ?? ''}}">
    <meta name="description" content="{{$description ?? ''}}">
    <title>{{$title ?? 'MeEdu'}}</title>
    <link rel="stylesheet" href="{{mix('/frontend/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/css/iconfont/iconfont.css')}}?v=4.2">
    <script src="{{mix('frontend/js/frontend.js')}}"></script>
    @yield('css')
    @if($css = $gConfig['system']['css']['pc'] ?? '')
        <style>
            {{$css}}
        </style>
    @endif
</head>
<body class="bg-gray-50">

@include('frontend.components.common.header')

@yield('content')

@include('frontend.components.common.footer')

<script>
    @if(get_first_flash('success'))
    flashSuccess("{{get_first_flash('success')}}");
    @endif
    @if(get_first_flash('warning'))
    flashWarning("{{get_first_flash('warning')}}");
    @endif
    @if(get_first_flash('error'))
    flashError("{{get_first_flash('error')}}");
    @endif
</script>
@yield('js')
<div style="display:none">{!! config('meedu.system.js') !!}</div>

</body>
</html>