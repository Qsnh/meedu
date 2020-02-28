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
    <title>{{$user ? $user['nick_name'].' - ' : ''}}{{$title ?? 'MeEdu'}}</title>
    <link crossorigin="anonymous" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
          href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/frontend/css/frontend.css')}}">
    <script src="{{asset('frontend/js/frontend.js')}}"></script>
    @yield('css')
</head>
<body class="bg-f6">

<div class="container-fluid nav-box bg-fff">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="navbar navbar-expand-lg bg-fff">
                            <a class="navbar-brand" href="{{url('/')}}">
                                <img src="{{$gConfig['system']['logo']}}" height="37" alt="{{config('app.name')}}">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-bars"></i>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link {{menu_active(['index'])}}" href="{{url('/')}}">首页 <span
                                                    class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{menu_active(['courses', 'videos', 'course.show', 'video.show'])}}"
                                           href="{{route('courses')}}">所有课程</a>
                                    </li>
                                    @foreach($gNavs as $item)
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->url() == $item['url'] ? 'active' : ''}}"
                                               href="{{$item['url']}}">{{$item['name']}}</a>
                                        </li>
                                    @endforeach
                                    <form class="form-inline ml-4" method="get" action="{{route('search')}}">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" class="form-control search-input" name="keywords"
                                                   placeholder="请输入关键字"
                                                   required>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary search-button" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </ul>

                                <a class="role-vip-button {{menu_active('role.index')}}"
                                   href="{{route('role.index')}}">
                                    <p><img src="/images/icons/vip.png" width="24" height="24"></p>
                                    <p>会员中心</p>
                                </a>

                                @if(!$user)
                                    <a class="login-button" onclick="showAuthBox('login-box')">登录</a>
                                @else
                                    <a class="message-button {{menu_active('member.messages')}}"
                                       href="{{route('member.messages')}}">
                                        <p><img src="/images/icons/message.png" width="24" height="24"></p>
                                        <p>消息</p>
                                        @if($gUnreadMessageCount)
                                            <span class="message-count">{{$gUnreadMessageCount}}</span>
                                        @endif
                                    </a>
                                    <div class="dropdown user-avatar">
                                        <a class="user-avatar-button" href="javascript:void(0);"
                                           id="navbarDropdown"
                                           role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="{{$user['avatar']}}" width="40" height="40">
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{route('member')}}">
                                                <img src="{{$user['avatar']}}" width="20" class="avatar"
                                                     height="20"><span>{{$user['nick_name']}}</span>
                                            </a>
                                            @if($user['role'] ?? [])
                                                <a class="dropdown-item vip" href="{{route('member.join_role_records')}}">
                                                    <img src="/images/icons/vip.png" width="20"
                                                         height="20"><span>{{$user['role']['name']}}</span>
                                                </a>
                                            @else
                                                <a class="dropdown-item vip" href="{{route('role.index')}}">
                                                    <img src="/images/icons/vip.png" width="20"
                                                         height="20"><span>成为会员</span>
                                                </a>
                                            @endif
                                            <a class="dropdown-item" href="{{route('member.courses')}}">
                                                <img src="/images/icons/course.png" width="20"
                                                     height="20"><span>我的课程</span>
                                            </a>
                                            <a class="dropdown-item" href="{{route('member.orders')}}">
                                                <img src="/images/icons/order.png" width="20"
                                                     height="20"><span>订单信息</span>
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                <img src="/images/icons/logout.png" width="20" height="20">
                                                <span>安全退出</span>
                                            </a>
                                            <form class="d-none" id="logout-form" action="{{ route('logout') }}"
                                                  method="POST"
                                                  style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<main>
    @yield('content')
</main>

<div class="auth-box">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4" id="auth-box-content">
            </div>
        </div>
    </div>
</div>
<script type="text/html" id="login-box">
    <form class="login-box" action="{{route('ajax.login.password')}}" method="post">
        <div class="login-box-title">
            <span class="title">密码登录</span>
            <img src="/images/close.png" width="24" height="24" class="close-auth-box">
        </div>
        <div class="login-box-menu">
            <span class="cursor-pointer" onclick="showAuthBox('mobile-login-box')">切换手机验证码登录></span>
        </div>
        <div class="login-box-content">
            <div class="form-group">
                <input type="text" class="form-control" name="mobile" placeholder="请输入手机号">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="请输入密码">
            </div>
            <div class="form-group login-remember">
                <label class="remember"><input type="checkbox" name="remember"> 15天内免登录</label>
                <span class="show-find-password" onclick="showAuthBox('password-find')">忘记密码</span>
                <span class="show-register-box float-right" onclick="showAuthBox('register-box')">立即注册</span>
            </div>
            <div class="form-group auth-box-errors"></div>
            <div class="form-group mt-2">
                <button type="button" class="btn btn-primary btn-block login-password-button">立即登录</button>
            </div>
            <div class="form-group text-center mb-0 socialite-box">
                @foreach(enabled_socialites() as $socialite)
                    <a class="socialite-item"
                       href="{{route('socialite', $socialite['app'])}}">{!! $socialite['icon'] !!}</a>
                @endforeach
            </div>
        </div>
    </form>
</script>

<script type="text/html" id="mobile-login-box">
    <form class="login-box" action="{{route('ajax.login.mobile')}}" method="post">
        <div class="login-box-title">
            <span class="title">手机号登录</span>
            <img src="/images/close.png" width="24" height="24" class="close-auth-box">
        </div>
        <div class="login-box-menu">
            <span class="cursor-pointer" onclick="showAuthBox('login-box')">切换密码登录></span>
        </div>
        <div class="login-box-content">
            <div class="form-group">
                <input type="text" class="form-control" name="mobile" placeholder="请输入手机号">
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="captcha" placeholder="验证码" class="form-control" required>
                    <div class="input-group-append">
                        <img src="{{ captcha_src() }}" class="captcha" width="120" height="36">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="hidden" name="sms_captcha_key" value="mobile_login">
                    <input type="text" name="sms_captcha" placeholder="手机验证码" class="form-control" required>
                    <input type="hidden" name="sms_captcha_key" value="{{$smsCaptchaKey ?? ''}}">
                    <div class="input-group-append">
                        <button type="button" style="width: 120px;"
                                class="send-sms-captcha btn btn-outline-primary">发送验证码
                        </button>
                    </div>
                </div>
            </div>
            <div class="form-group login-remember">
                <label class="remember"><input type="checkbox" name="remember"> 15天内免登录</label>
            </div>
            <div class="form-group auth-box-errors"></div>
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-block login-mobile-button">立即登录</button>
            </div>
            <div class="form-group text-center mb-0 socialite-box">
                @foreach(enabled_socialites() as $socialite)
                    <a class="socialite-item"
                       href="{{route('socialite', $socialite['app'])}}">{!! $socialite['icon'] !!}</a>
                @endforeach
            </div>
        </div>
    </form>
</script>

<script type="text/html" id="password-find">
    <form class="login-box" action="{{route('ajax.password.reset')}}" method="post">
        @csrf
        <div class="login-box-title" style="margin-bottom: 30px;">
            <span class="title">找回密码</span>
            <img src="/images/close.png" width="24" height="24" class="close-auth-box">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="mobile" placeholder="请输入手机号">
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="captcha" placeholder="验证码" class="form-control" required>
                <div class="input-group-append">
                    <img src="{{ captcha_src() }}" class="captcha" width="120" height="36">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="sms_captcha" placeholder="手机验证码" class="form-control" required>
                <input type="hidden" name="sms_captcha_key" value="password_reset">
                <div class="input-group-append">
                    <button type="button" style="width: 120px;"
                            class="send-sms-captcha btn btn-outline-primary">发送验证码
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input id="password" type="password" class="form-control" placeholder="新密码"
                   name="password" required>
        </div>
        <div class="form-group">
            <input id="password-confirm" type="password" class="form-control"
                   placeholder="再输入一次" name="password_confirmation" required>
        </div>
        <div class="form-group auth-box-errors"></div>
        <div class="form-group mb-0">
            <button type="button" class="btn btn-primary btn-block password-reset-button">重置密码</button>
        </div>
    </form>
</script>

<script id="register-box" type="text/html">
    <form class="login-box" action="{{route('ajax.register')}}" method="post">
        @csrf
        <div class="login-box-title" style="margin-bottom: 30px;">
            <span class="title">注册</span>
            <img src="/images/close.png" width="24" height="24" class="close-auth-box">
        </div>
        <div class="form-group">
            <input id="nick_name" type="text" class="form-control" placeholder="昵称"
                   name="nick_name" value="{{ old('nick_name') }}" required>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="mobile" placeholder="请输入手机号">
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="captcha" placeholder="验证码" class="form-control" required>
                <div class="input-group-append">
                    <img src="{{ captcha_src() }}" class="captcha" width="120" height="36">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="sms_captcha" placeholder="手机验证码" class="form-control" required>
                <input type="hidden" name="sms_captcha_key" value="register">
                <div class="input-group-append">
                    <button type="button" style="width: 120px;"
                            class="send-sms-captcha btn btn-outline-primary">发送验证码
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <input id="password" type="password" class="form-control" placeholder="密码"
                   name="password" required>
        </div>
        <div class="form-group">
            <input id="password-confirm" type="password" class="form-control"
                   placeholder="再输入一次" name="password_confirmation" required>
        </div>
        <div class="form-group login-remember">
            <label class="user_protocol"><input type="checkbox"
                                                name="agree_protocol" {{ old('remember') ? 'checked' : '' }}>
                我已阅读并同意
                <a href="{{route('user.protocol')}}" target="_blank">《{{config('app.name')}}
                    用户协议》</a></label>

            <span class="float-right show-login-box" onclick="showAuthBox('login-box')">立即登录</span>
        </div>
        <div class="form-group auth-box-errors"></div>
        <div class="form-group mb-0">
            <button type="button" class="btn btn-primary btn-block register-button">立即注册</button>
        </div>
    </form>
</script>

<script id="mobile-bind-box" type="text/html">
    <form class="login-box" action="{{route('ajax.mobile.bind')}}" method="post">
        <div class="login-box-title" style="margin-bottom: 30px;">
            <span class="title">手机号绑定</span>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="mobile" placeholder="请输入手机号">
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="captcha" placeholder="验证码" class="form-control" required>
                <div class="input-group-append">
                    <img src="{{ captcha_src() }}" class="captcha" width="120" height="36">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <input type="text" name="sms_captcha" placeholder="手机验证码" class="form-control" required>
                <input type="hidden" name="sms_captcha_key" value="mobile_bind">
                <div class="input-group-append">
                    <button type="button" style="width: 120px;"
                            class="send-sms-captcha btn btn-outline-primary">发送验证码
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group auth-box-errors"></div>
        <div class="form-group mb-0">
            <button type="button" class="btn btn-primary btn-block mobile-bind-button">立即绑定</button>
        </div>
    </form>
</script>

@section('footer')
    <footer class="container-fluid footer-box">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <p>Powered By <a href="https://meedu.vip" target="_blank">MeEdu</a></p>
                    <p>© {{date('Y')}} {{config('app.name')}} · <a href="http://www.beian.miit.gov.cn"
                                                                   target="_blank">{{$gConfig['system']['icp']}}</a></p>
                </div>
            </div>
        </div>
    </footer>
@show

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
@if($bindMobileState)
    <script>
        showAuthBox('mobile-bind-box');
    </script>
@endif
@yield('js')
<div style="display:none">{!! config('meedu.system.js') !!}</div>
</body>
</html>