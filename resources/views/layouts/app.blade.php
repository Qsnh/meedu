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
                                           href="{{route('courses')}}">课程</a>
                                    </li>
                                    @foreach($gNavs as $item)
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{$item['url']}}">{{$item['name']}}</a>
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
                                   href="{{route('role.index')}}">会员中心</a>

                                @if(!$user)
                                    <a class="login-button" href="{{route('login')}}">登录</a>
                                @else
                                    <a href="{{route('member.messages')}}">
                                        <i class="fa fa-comments"></i>
                                        @if($gUnreadMessageCount)
                                            <span class="badge badge-danger">{{$gUnreadMessageCount}}</span>
                                        @endif
                                    </a>
                                    <div class="dropdown">
                                        <a class="nav-link dropdown-toggle" href="javascript:void(0);"
                                           id="navbarDropdown"
                                           role="button"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{$user['nick_name']}}
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{route('member')}}">会员中心</a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">安全退出</a>
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
@yield('js')
<div style="display:none">{!! config('meedu.system.js') !!}</div>
</body>
</html>