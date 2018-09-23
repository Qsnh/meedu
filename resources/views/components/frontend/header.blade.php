<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'MeEdu') }}
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li>
                    <a class="{{ menu_is_active('index') }}" href="{{ url('/') }}">首页</a>
                </li>
                <li>
                    <a class="{{ menu_is_active('courses') }}" href="{{ route('courses') }}">课程</a>
                </li>
                <li>
                    <a class="{{ menu_is_active('role.index') }}" href="{{ route('role.index') }}">订阅本站</a>
                </li>
                <li>
                    <a class="{{ menu_is_active('faq') }}" href="{{ route('faq') }}">FAQ</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">登陆</a></li>
                    <li><a href="{{ route('register') }}">注册</a></li>
                @else
                    @if(Auth::check())
                    <li>
                        <a href="{{ route('member.messages') }}">
                            @if(count($user->unreadNotifications))
                                <span class="label label-danger">{{ count($user->unreadNotifications) }}
                                @else
                                <span class="label label-default">0</span>
                            @endif
                        </a>
                    </li>
                    @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                            {{ $user->nick_name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('member') }}">会员中心</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    安全退出
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>