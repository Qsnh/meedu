@include('layouts.common.header')

<body class="bg-f6">

<div class="container-fluid nav-box member-nav-box">
    <div class="row">
        <div class="col-sm-12">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="{{url('/')}}">
                                <img src="{{$gConfig['system']['member_logo']}}" height="37"
                                     alt="{{config('app.name')}}">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fa fa-bars"></i>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{url('/')}}">首页 <span
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
                        <div>
                            <img src="/images/icons/member/vip.png" width="24" height="24">
                            <span class="member-menu-item-title vip">会员中心</span>
                        </div>
                        <div class="dot-box">
                            <span class="dot"></span>
                        </div>
                    </a>
                    <a href="{{route('member.courses')}}" class="{{menu_active('member.courses')}}">
                        <div>
                            <img src="/images/icons/member/course.png" width="24" height="24">
                            <span class="member-menu-item-title">我的课程</span>
                        </div>
                        <div class="dot-box">
                            <span class="dot"></span>
                        </div>
                    </a>
                    <a href="{{route('member')}}" class="{{menu_active('member')}}">
                        <div>
                            <img src="/images/icons/member/profile.png" width="24" height="24">
                            <span class="member-menu-item-title">我的资料</span>
                        </div>
                        <div class="dot-box">
                            <span class="dot"></span>
                        </div>
                    </a>
                    <a href="{{route('member.orders')}}" class="{{menu_active('member.orders')}}">
                        <div>
                            <img src="/images/icons/member/order.png" width="24" height="24">
                            <span class="member-menu-item-title">订单信息</span>
                        </div>
                        <div class="dot-box">
                            <span class="dot"></span>
                        </div>
                    </a>
                    <a href="{{route('member.promo_code')}}" class="{{menu_active('member.promo_code')}}">
                        <div>
                            <img src="/images/icons/member/invite.png" width="24" height="24">
                            <span class="member-menu-item-title">我的邀请码</span>
                        </div>
                        <div class="dot-box">
                            <span class="dot"></span>
                        </div>
                    </a>
                    <a href="{{route('member.messages')}}" class="{{menu_active('member.messages')}}">
                        <div>
                            <img src="/images/icons/member/message.png" width="24" height="24">
                            <span class="member-menu-item-title">我的消息</span>
                        </div>
                        <div class="dot-box">
                            <span class="dot"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@yield('member')

@include('layouts.common.footer')

</body>
</html>