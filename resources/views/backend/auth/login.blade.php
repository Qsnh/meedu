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
    <script crossorigin="anonymous" integrity="sha384-RIQuldGV8mnjGdob13cay/K1AJa+LR7VKHqSXrrB5DPGryn4pMUXRLh92Ev8KlGF" src="https://lib.baomitu.com/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link crossorigin="anonymous" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" href="https://lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
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
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
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
                    <form class="card" action="" method="post">
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
                                    <input type="checkbox" name="remember_me" value="1" class="custom-control-input" />
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

    <script>
        @if(get_first_flash('success'))
        swal("成功", "{{get_first_flash('success')}}", "success");
        @endif
        @if(get_first_flash('warning'))
        swal("警告", "{{get_first_flash('warning')}}", "warning");
        @endif
        @if(get_first_flash('error'))
        swal("错误", "{{get_first_flash('error')}}", "error");
        @endif
    </script>
</div>
</body>
</html>