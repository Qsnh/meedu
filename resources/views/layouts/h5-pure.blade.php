<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{$keywords ?? ''}}">
    <meta name="description" content="{{$description ?? ''}}">
    <title>{{$title ?? 'MeEdu'}}</title>
    <link crossorigin="anonymous" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
          href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('/h5/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/h5/css/iconfont/iconfont.css')}}">
    <script crossorigin="anonymous" integrity="sha384-qu2J8HSjv8EaYlbzBdbVeJncuCmfBqnZ4h3UIBZ9WTZ/5Wrqt0/9hofL0046NCkc"
            src="https://lib.baomitu.com/zepto/1.2.0/zepto.min.js"></script>
    <script src="{{asset('/h5/js/zepto-touch.js')}}"></script>
    <script src="{{mix('/h5/js/app.js')}}"></script>
    @yield('css')
    @if($css = $gConfig['system']['css']['h5'] ?? '')
        <style>
            {{$css}}
        </style>
    @endif
</head>
<body>

@yield('content')

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
@include('h5.components.mobile_bind')
@yield('js')
<div style="display:none">{!! config('meedu.system.js') !!}</div>
</body>
</html>