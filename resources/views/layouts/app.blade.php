@include('layouts.common.header')
<body>

<div class="nav-box">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="{{url('/')}}">
                        <img src="{{$gConfig['system']['logo']}}" height="37" alt="{{config('app.name')}}">
                    </a>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link {{menu_active(['index'])}}" href="{{url('/')}}">首页</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{menu_active(['courses', 'videos', 'course.show', 'video.show'])}}"
                                   href="{{route('courses')}}">所有课程</a>
                            </li>
                            @foreach($gNavs as $item)
                                @if($item['children'])
                                    <li class="nav-item">
                                        <a class="nav-link {{menu_active(explode(',', $item['active_routes'] ?? ''))}}"
                                           href="{{$item['url']}}" {!! $item['blank'] ? 'target="_blank"' : '' !!}>{{$item['name']}}</a>
                                        <div class="nav-children">
                                            @foreach($item['children'] as $childrenItem)
                                                <a class="children-nav-item {{menu_active(explode(',', $childrenItem['active_routes'] ?? ''))}}"
                                                   href="{{$childrenItem['url']}}" {!! $childrenItem['blank'] ? 'target="_blank"' : '' !!}>{{$childrenItem['name']}}</a>
                                            @endforeach
                                        </div>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link {{menu_active(explode(',', $item['active_routes'] ?? ''))}}"
                                           href="{{$item['url']}}" {!! $item['blank'] ? 'target="_blank"' : '' !!}>{{$item['name']}}</a>
                                    </li>
                                @endif
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
                            <a class="login-button login-auth" href="{{route('login')}}" data-login="0">登录</a>
                        @else
                            <div class="dropdown user-avatar">
                                <a class="user-avatar-button" href="javascript:void(0);"
                                   id="navbarDropdown"
                                   role="button"
                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{$user['avatar']}}" width="40" height="40">
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @if(app()->make(\App\Businesses\BusinessState::class)->isRole($user))
                                        <a class="dropdown-item vip"
                                           href="{{route('member.join_role_records')}}">
                                            <img src="/images/icons/vip.png" width="20"
                                                 height="20"><span>{{$user['role']['name']}}</span>
                                        </a>
                                    @else
                                        <a class="dropdown-item vip" href="{{route('role.index')}}">
                                            <img src="/images/icons/vip.png" width="20"
                                                 height="20"><span>成为会员</span>
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{route('member')}}">
                                        <img src="{{$user['avatar']}}" width="20" class="avatar"
                                             height="20"><span>用户中心</span>
                                    </a>
                                    <a class="dropdown-item" href="{{route('member.courses')}}">
                                        <img src="/images/icons/course.png" width="20"
                                             height="20"><span>我的课程</span>
                                    </a>
                                    <a class="dropdown-item" href="{{route('member.orders')}}">
                                        <img src="/images/icons/order.png" width="20"
                                             height="20"><span>订单信息</span>
                                    </a>
                                    <a class="dropdown-item logout" href="javascript:void(0);" onclick="event.preventDefault();
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

@yield('content')

@include('layouts.common.footer')
</body>
</html>