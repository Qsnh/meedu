<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'MeEdu') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <ul class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li>
                    <a class="{{ menu_is_active('index') }}" href="{{ url('/') }}">首页</a>
                </li>
                @if(config('meedu.system.indexMenu.course'))
                <li>
                    <a class="{{ menu_is_active('courses') }}" href="{{ route('courses') }}">课程</a>
                </li>
                @endif
                @if(config('meedu.system.indexMenu.book'))
                <li>
                    <a class="{{ menu_is_active('books') }}" href="{{ route('books') }}">电子书</a>
                </li>
                @endif
                @if(config('meedu.system.indexMenu.vip'))
                <li>
                    <a class="{{ menu_is_active('role.index') }}" href="{{ route('role.index') }}">订阅本站</a>
                </li>
                @endif
                @if(config('meedu.system.indexMenu.faq'))
                <li>
                    <a class="{{ menu_is_active('faq') }}" href="{{ route('faq') }}">FAQ</a>
                </li>
                @endif
            </ul>

            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">登录</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">注册</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('member.messages') }}">
                            <span class="badge badge-primary">{{ count($user->unreadNotifications) }}</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $user->nick_name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li class="dropdown-item">
                                <a href="{{ route('member') }}">会员中心</a>
                            </li>
                            <li class="dropdown-item">
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    安全退出
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>