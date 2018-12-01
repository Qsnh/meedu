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
    <style>
        /* source-sans-pro-300 */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 300;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Normal'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-300italic */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 300;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300italic.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Italic'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300italic.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300italic.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300italic.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300italic.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-300italic.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-regular */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: regular;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-regular.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Normal'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-regular.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-regular.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-regular.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-regular.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-regular.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-italic */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: regular;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-italic.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Italic'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-italic.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-italic.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-italic.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-italic.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-italic.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-500 */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 500;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Normal'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-500italic */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 500;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500italic.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Italic'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500italic.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500italic.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500italic.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500italic.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-500italic.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-600 */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 600;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Normal'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-600italic */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 600;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600italic.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Italic'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600italic.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600italic.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600italic.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600italic.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-600italic.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-700 */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: normal;
            font-weight: 700;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Normal'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }

        /* source-sans-pro-700italic */
        @font-face {
            font-family: 'Source Sans Pro';
            font-style: italic;
            font-weight: 700;
            src: url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700italic.eot'); /* IE9 Compat Modes */
            src: local('Source Sans Pro'), local('SourceSans Pro-Italic'),
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700italic.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700italic.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700italic.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700italic.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/source-sans-pro/source-sans-pro-700italic.svg#SourceSans Pro') format('svg'); /* Legacy iOS */
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/js/layx/layx.min.css') }}">
    <script src="/backend/assets/js/require.min.js"></script>
    <script>
        requirejs.config({
            baseUrl: '.'
        });
    </script>
    <!-- Dashboard Core -->
    <link href="/backend/assets/css/dashboard.css" rel="stylesheet" />
    <script src="/backend/assets/js/dashboard.js"></script>
    <!-- Input Mask Plugin -->
    <script src="/backend/assets/plugins/input-mask/plugin.js"></script>
    @yield('css')
</head>
<body class="">
<div class="page">

    <div class="page-main" id="app">
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
            <div class="container">
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

    <script src="{{ mix('js/backend.js') }}"></script>
    <script src="{{ asset('js/layx/layx.min.js') }}"></script>
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