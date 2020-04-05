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
    <link rel="stylesheet" href="{{asset('/h5/css/app.css')}}">
    <script crossorigin="anonymous" integrity="sha384-qu2J8HSjv8EaYlbzBdbVeJncuCmfBqnZ4h3UIBZ9WTZ/5Wrqt0/9hofL0046NCkc" src="https://lib.baomitu.com/zepto/1.2.0/zepto.min.js"></script>
    <script src="{{asset('/h5/js/zepto-touch.js')}}"></script>
    <script src="{{asset('/h5/js/app.js')}}"></script>
    @yield('css')
</head>
<body style="padding-top: 52px;">

<div class="top-header">
    <a href="{{route('index')}}">
        <img src="{{$gConfig['system']['white_logo']}}" height="24" width="92">
    </a>
    @if($user)
        <a href="javascript:void(0)" class="float-right" onclick="$('.member-model').toggle()">
            <img src="{{$user['avatar']}}" class="avatar" width="28" height="28">
        </a>
    @else
        <a href="{{route('login')}}" class="float-right">
            <img src="{{asset('/h5/images/icons/user.png')}}" width="28" height="28">
        </a>
    @endif
    <a href="{{route('search')}}" class="float-right search-button">
        <img src="{{asset('/h5/images/icons/search.png')}}" width="20" height="20">
    </a>
</div>
<div class="top-menu">
    <a href="{{route('index')}}" class="{{menu_active(['index'])}} first">首页</a>
    <a href="{{route('courses')}}" class="{{menu_active(['courses'])}}">所有课程</a>
    @foreach($gNavs as $item)
        <a class="{{request()->url() === $item['url'] ? 'active' : ''}}"
           href="{{$item['url']}}">{{$item['name']}}</a>
    @endforeach
</div>

@yield('content')

@if($user)
    <div class="member-model">
        <div class="menu-box">
            @if(app()->make(\App\Businesses\BusinessState::class)->isRole($user))
                <a href="javascript:void(0)" class="menu-item vip">
                    <img src="{{asset('/h5/images/icons/vip.png')}}" width="20" height="20" class="icon">
                    <span>{{$user['role']['name']}}</span>
                </a>
            @else
                <a href="{{route('role.index')}}" class="menu-item vip">
                    <img src="{{asset('/h5/images/icons/vip.png')}}" width="20" height="20"
                         class="icon"><span>会员中心</span>
                </a>
            @endif
            <a href="{{route('member.courses')}}" class="menu-item">
                <img src="{{asset('/h5/images/icons/course.png')}}" width="20" height="20" class="icon">
                <span>我的课程</span>
            </a>
            <a href="{{route('member.orders')}}" class="menu-item">
                <img src="{{asset('/h5/images/icons/order.png')}}" width="20" height="20" class="icon">
                <span>我的订单</span>
            </a>
            <a href="javascript:void(0)" class="menu-item" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                <img src="{{asset('/h5/images/icons/logout.png')}}" width="20" height="20" class="icon">
                <span>退出登录</span>
            </a>
            <form class="d-none" id="logout-form" action="{{ route('logout') }}"
                  method="POST"
                  style="display: none;">
                @csrf
            </form>
        </div>
    </div>
@endif

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