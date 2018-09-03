<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$title ?? Auth::user()->nick_name }} 会员中心 - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/frontend.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend_diy.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @include('components.frontend.header')
    <div class="container member">
        <div class="col-sm-3 member-left-box">
            <div class="row">
                <div class="col-sm-12 avatar border">
                    <p>
                        <a href="{{ route('member.avatar') }}">
                            <img src="{{ Auth::user()->avatar }}" width="80" height="80">
                        </a>
                    </p>
                    <p class="nickname">{{ Auth::user()->nick_name }}</p>
                    <p class="lh-30">注册于 &nbsp; <span class="color-gray">{{ Auth::user()->created_at->diffForHumans() }}</span></p>
                    <p class="lh-30">
                        @if(Auth::user()->role)
                            <span class="label label-success">{{Auth::user()->role->name}}</span>
                        @endif
                    </p>
                    <p class="lh-30">余额
                        <b>{{ Auth::user()->credit1 }}</b>&nbsp; <a href="{{ route('member.recharge') }}">充值</a>
                    </p>
                </div>

                <div class="col-sm-12 member-left-menu border">
                    <ul>
                        <li>
                            <a href="{{ route('member') }}">
                                <i class="fa fa-dashboard"></i> 会员中心
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.messages') }}">
                                <i class="fa fa-comments"></i> 我的消息
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.courses') }}">
                                <i class="fa fa-file"></i> 已购课程
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.course.videos') }}">
                                <i class="fa fa-film"></i> 已购视频
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.join_role_records') }}">
                                <i class="fa fa-users"></i> 会员记录
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.password_reset') }}">
                                <i class="fa fa-cogs"></i> 修改密码
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> 安全退出
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-sm-9 member-box border">
            <div class="col-sm-12">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('components.frontend.footer')
@yield('js')
</body>
</html>