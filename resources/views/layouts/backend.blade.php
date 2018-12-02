<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MeEdu后台管理系统</title>
    <link crossorigin="anonymous" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/js/layx/layx.min.css') }}">
    <link crossorigin="anonymous" integrity="sha384-sr24+N5hvbO83z6WV4A9zRt0bXHxKxmHiE2MliCVO6ic+CIbnJsqndMaaM6kdShS" href="https://lib.baomitu.com/flatpickr/4.5.2/flatpickr.min.css" rel="stylesheet">
    <link href="/backend/assets/css/dashboard.css" rel="stylesheet" />
    <script crossorigin="anonymous" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" src="https://lib.baomitu.com/jquery/3.3.1/jquery.min.js"></script>
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<div class="page">
    <div class="page-main">
        <div class="header py-4">
            <div class="container">
                <div class="d-flex">
                    <a class="header-brand" href="{{route('backend.dashboard.index')}}">MeEdu</a>
                    <div class="d-flex order-lg-2 ml-auto">
                        <div class="dropdown">
                            <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                <span class="ml-2 d-none d-lg-block">
                                  <span class="text-default">{{ Auth::guard('administrator')->user()->name }}</span>
                                  <small class="text-muted d-block mt-1">Administrator</small>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                <a class="dropdown-item" href="{{ route('backend.edit.password') }}">
                                    <i class="dropdown-icon fe fe-settings"></i> 修改密码
                                </a>
                                <a class="dropdown-item" href="{{ route('backend.logout') }}">
                                    <i class="dropdown-icon fe fe-log-out"></i> 安全退出
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon"></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg order-lg-first">
                        <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                            @foreach(backend_menus() as $menu)
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link" data-toggle="dropdown">{{$menu->name}}</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                    @foreach($menu->children as $child)
                                            <a href="{{$child->url}}" class="dropdown-item ">{{$child->name}}</a>
                                    @endforeach
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-3 my-md-5">
            <div class="container" id="app">
                @yield('body')
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-auto ml-lg-auto">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <a href="https://github.com/Qsnh/meedu" class="btn btn-outline-primary btn-sm">源代码</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                    Copyright © 2018 <a href="https://github.com/Qsnh/meedu">MeEdu</a>. Created by <a href="https://58hualong.cn" target="_blank">@XiaoTeng</a> All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="{{ asset('js/layx/layx.min.js') }}"></script>
    <script src="{{ mix('js/backend.js') }}"></script>
    <script crossorigin="anonymous" integrity="sha384-OpRdsqyoNpMsxINrUErWMPDGYcDdgDXG+MefUFBy42yukJGecar+6uS4HBGGWb+e" src="https://lib.baomitu.com/flatpickr/4.5.2/flatpickr.min.js"></script>
    <script crossorigin="anonymous" integrity="sha384-uOV94oddoQmmdQhRtBPzXMX7CBxGVw888Cp9gjgRspAq/go5oea3c+cS8OlY+N6C" src="https://lib.baomitu.com/wangEditor/3.1.1/wangEditor.min.js"></script>
    <script>
        @if(get_first_flash('success'))
        layx.msg("{{get_first_flash('success')}}",{dialogIcon:'success'});
        @endif
        @if(get_first_flash('warning'))
        layx.msg("{{get_first_flash('warning')}}",{dialogIcon:'warn'});
        @endif
        @if(get_first_flash('error'))
        layx.msg("{{get_first_flash('error')}}",{dialogIcon:'error'});
        @endif
    </script>
    @yield('js')
</div>
</body>
</html>