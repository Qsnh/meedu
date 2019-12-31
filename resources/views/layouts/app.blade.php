<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{$keywords ?? ''}}">
    <meta name="description" content="{{$description ?? ''}}">
    <title>{{Auth::check() ? Auth::user()->nick_name.' - ' : ''}}{{$title ?? 'MeEdu'}}</title>
    <!-- Styles -->
    <link href="{{asset('/frontend/assets/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/assets/css/app.min.css')}}" rel="stylesheet">
    <link href="{{asset('/frontend/assets/css/style.min.css')}}" rel="stylesheet">
    <link crossorigin="anonymous" integrity="sha384-6SClQBVFSY83VyPkr36mKEIuaHcXN69N5F076i0mYvEIsVK73AlDn/6vL2PyunVW" href="//lib.baomitu.com/limonte-sweetalert2/7.33.1/sweetalert2.min.css" rel="stylesheet">
    @yield('css')
</head>
<body style="padding-top: 64px;">

<header class="topbar topbar-unfix">
    <div class="topbar-left">
        <span class="topbar-brand">
            <a href="{{route('index')}}"><img src="{{asset('/frontend/logo.png')}}" alt="logo-icon"></a>
        </span>
        <div class="topbar-divider d-none d-xl-block"></div>
        <nav class="topbar-navigation">
            <ul class="menu">
                <li class="menu-item {{app_menu_is_active('index') ? 'active' : ''}}">
                    <a class="menu-link" href="{{url('/')}}">
                        <span class="icon ti-home"></span>
                        <span class="title">首页</span>
                    </a>
                </li>
                <li class="menu-item {{app_menu_is_active('courses') ? 'active' : ''}}">
                    <a class="menu-link" href="{{route('courses')}}">
                        <span class="icon ti-headphone-alt"></span>
                        <span class="title">课程</span>
                    </a>
                </li>
                <li class="menu-item {{app_menu_is_active('role') ? 'active' : ''}}">
                    <a class="menu-link" href="{{route('role.index')}}">
                        <span class="icon ti-gift"></span>
                        <span class="title">订阅</span>
                    </a>
                </li>
                @foreach($gNavs as $item)
                    <li class="menu-item">
                        <a class="menu-link" href="{{$item['url']}}"><span class="title">{{$item['name']}}</span></a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <div class="topbar-right">
        <ul class="topbar-btns">
            <li class="dropdown">
                <span class="topbar-btn" data-toggle="dropdown">
                    @guest
                    <img class="avatar" src="/frontend/assets/img/avatar/1.jpg">
                    @else
                    <img class="avatar" src="{{$user['avatar']}}">
                    @endguest
                </span>
                <div class="dropdown-menu dropdown-menu-right">
                    @guest
                        <a class="dropdown-item" href="{{ route('login') }}"><i class="ti-user"></i> 登录</a>
                        <a class="dropdown-item" href="{{ route('register') }}"><i class="ti-user"></i> 注册</a>
                        @else
                        <a class="dropdown-item" href="{{ route('member') }}"><i class="ti-user"></i> 会员中心</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                            <i class="ti-power-off"></i> 安全退出
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        @endguest
                </div>
            </li>
            @auth
            <li class="d-none d-md-block">
                <a  href="{{route('member.messages')}}" class="topbar-btn {{ $gUnreadMessageCount > 0 ? 'has-new' : '' }}">
                    <i class="ti-bell"></i>
                </a>
            </li>
            @endauth
        </ul>
    </div>
</header>

@yield('content')

<footer class="site-footer pt-50 pb-20">
    <div class="container">
        <div class="row gap-y">
            <div class="col-md-3 col-sm-12">
                <h5 class="text-uppercase fs-14 ls-1">关于我们</h5>
                <p class="text-justify">
                    MeEdu 是专为为个人开发的开源免费的在线点播系统。使用 MeEdu 你可以在短短几分钟之内搭建一个功能完善的在线教育系统。MeEdu 专注视频
                    的付费点播，结合丰富插件足以满足您的任何要求。
                </p>
            </div>

            <div class="col-md-3 col-sm-12 text-left1 text-lg-center1">
                <h5 class="text-uppercase fs-14 ls-1">MeEdu</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/Qsnh/meedu">源码</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/Qsnh/meedu/issues">Bug反馈</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-12 text-left1 text-lg-center1">
                <h5 class="text-uppercase fs-14 ls-1">服务支持</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="https://meedu.vip">官网</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://meedu.vip">插件</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-12 text-left1 text-lg-center1">
                <h5 class="text-uppercase fs-14 ls-1">服务支持</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="https://meedu.vip">官网</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://meedu.vip">插件</a>
                    </li>
                </ul>
            </div>

        </div>

        <hr>

        <div class="row">
            <div class="col-md-6 justify-content-center justify-content-md-start">
                <p>Copyright © 2019 <a href="https://github.com/Qsnh/meedu">MeEdu</a>. All rights reserved.</p>
            </div>

            <div class="col-md-6">
                <ul class="nav nav-primary nav-dotted nav-dot-separated justify-content-center justify-content-md-end">
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/Qsnh/meedu">源码</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://meedu.vip">Website</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>


<!-- Scripts -->
<script src="{{asset('/frontend/assets/js/core.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/app.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/script.min.js')}}"></script>
<script crossorigin="anonymous" integrity="sha384-yhphg78T9x4D5MygsNWDAL6NRy6UurEwbp81HAeiKaBIh7rUi1+BIwJMlYJuPBlW" src="//lib.baomitu.com/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
<script>
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