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

<div class="container-fluid nav-box member-nav-box">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{url('/')}}">
                                <img src="{{$gConfig['system']['member_logo']}}" height="37" alt="{{config('app.name')}}">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-bars"></i>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link pl-0" href="{{url('/')}}">首页 <span
                                                    class="sr-only">(current)</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('courses')}}">所有课程</a>
                                    </li>
                                    @foreach($gNavs as $item)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{$item['url']}}">{{$item['name']}}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <a class="role-vip-button hover-img-switch {{menu_active('role.index')}}"
                                   href="{{route('role.index')}}">
                                    <p><img src="/images/icons/member/vip.png" width="24" height="24"></p>
                                    <p>会员中心</p>
                                </a>

                                <a class="message-button hover-img-switch {{menu_active('member.messages')}}"
                                   href="{{route('member.messages')}}">
                                    <p><img src="/images/icons/member/message.png" width="24" height="24"></p>
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
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="member-menu-parent">
    <div class="container-fluid member-menu">
        <div class="container">
            <div class="row">
                <div class="col-12 member-menu-box">
                    <a href="{{route('member.join_role_records')}}" class="{{menu_active('member.join_role_records')}}">
                        <img src="/images/icons/member/vip.png" width="24" height="24">
                        <span class="member-menu-item-title vip">会员中心</span>
                    </a>
                    <a href="{{route('member.courses')}}" class="{{menu_active('member.courses')}}">
                        <img src="/images/icons/member/course.png" width="24" height="24">
                        <span class="member-menu-item-title">我的课程</span>
                    </a>
                    <a href="{{route('member')}}" class="{{menu_active('member')}}">
                        <img src="/images/icons/member/profile.png" width="24" height="24">
                        <span class="member-menu-item-title">我的资料</span>
                    </a>
                    <a href="{{route('member.orders')}}" class="{{menu_active('member.orders')}}">
                        <img src="/images/icons/member/order.png" width="24" height="24">
                        <span class="member-menu-item-title">订单信息</span>
                    </a>
                    <a href="{{route('member.promo_code')}}" class="{{menu_active('member.promo_code')}}">
                        <img src="/images/icons/member/invite.png" width="24" height="24">
                        <span class="member-menu-item-title">我的邀请码</span>
                    </a>
                    <a href="{{route('member.messages')}}" class="{{menu_active('member.messages')}}">
                        <img src="/images/icons/member/message.png" width="24" height="24">
                        <span class="member-menu-item-title">我的消息</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@yield('member')

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
<script>
    function showAuthBox($box) {
        $('#auth-box-content').html($('#' + $box).html());
        $('.auth-box').show();
    };
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