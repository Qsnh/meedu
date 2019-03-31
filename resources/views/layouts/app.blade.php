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
</head>
<body style="padding-top: 64px;">

<header class="topbar topbar-unfix">
    <div class="topbar-left">
        <span class="topbar-brand"><img src="{{asset('/frontend/logo.png')}}" alt="logo-icon"></span>
        <div class="topbar-divider d-none d-xl-block"></div>
        <nav class="topbar-navigation">
            <ul class="menu">
                <li class="menu-item active">
                    <a class="menu-link" href="{{url('/')}}">
                        <span class="icon ti-home"></span>
                        <span class="title">首页</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{route('courses')}}">
                        <span class="icon ti-headphone-alt"></span>
                        <span class="title">课程</span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link" href="{{route('role.index')}}">
                        <span class="icon ti-gift"></span>
                        <span class="title">订阅</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="topbar-right">
        <ul class="topbar-btns">
            <li class="dropdown">
                <span class="topbar-btn" data-toggle="dropdown"><img class="avatar" src="../assets/img/avatar/1.jpg" alt="..."></span>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#"><i class="ti-user"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i class="ti-help"></i> Help</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="ti-power-off"></i> Logout</a>
                </div>
            </li>

        </ul>

    </div>
</header>

@yield('content')

<footer class="site-footer pt-50 pb-20">
    <div class="row gap-y">
        <div class="col-lg-5">
            <h5 class="text-uppercase fs-14 ls-1">关于我们</h5>
            <p class="text-justify">
                MeEdu 是一款转为个人开发的开源免费的在线点播系统。依靠 MeEdu 可以在短短几分钟之内搭建一个功能完善的在线教育系统。MeEdu 专注与视频
                的付费点播，结合数百款插件足以满足您的任何要求。
            </p>
        </div>

        <div class="col-6 col-md-4 col-lg-2 text-left1 text-lg-center1">
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

        <div class="col-6 col-md-4 col-lg-2 text-left1 text-lg-center1">
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

        <div class="col-6 col-md-4 col-lg-2 text-left1 text-lg-center1">
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
</footer>


<!-- Scripts -->
<script src="{{asset('/frontend/assets/js/core.min.js')}}" data-provide="sweetalert"></script>
<script src="{{asset('/frontend/assets/js/app.min.js')}}"></script>
<script src="{{asset('/frontend/assets/js/script.min.js')}}"></script>
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