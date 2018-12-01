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
    <title>登录 - MeEdu后台管理系统 - https://github.com/Qsnh/meedu</title>
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
</head>
<body class="">
<div class="page">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto">
                    <div class="text-center mb-6">
                        <h3>MeEdu</h3>
                    </div>
                    <form class="card" action="{{route('backend.login')}}" method="post">
                        @csrf
                        <div class="card-body p-6">
                            <div class="card-title">登录</div>
                            <div class="form-group">
                                <label class="form-label">邮箱</label>
                                <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="请输入邮箱">
                            </div>
                            <div class="form-group">
                                <label class="form-label">密码</label>
                                <input type="password" name="password" class="form-control" placeholder="请输入密码">
                            </div>
                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" />
                                    <span class="custom-control-label">记住我</span>
                                </label>
                            </div>
                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary btn-block">登录</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
</div>
</body>
</html>