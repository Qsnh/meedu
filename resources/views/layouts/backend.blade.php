<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MeEDU后台管理系统</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        li {
            list-style: none;
        }
        .backend-top {
            background-color: #409EFF; color: #ffffff;
            padding-left: 20px; padding-right: 20px;
        }
        .backend-top .administrator {
            float: right; font-size: 16px; line-height: 39px;
            color: #ffffff; cursor: pointer;
        }

        .backend-left {
            background-color: #303133; color: #ffffff;
            padding: 20px;
        }
        .backend-left ul {
            padding: 0px; margin: 0px;
        }

        .backend-body {
            padding: 10px 20px;
        }
    </style>
    @yield('css')
</head>
<body>

<div id="app">
    <el-row>
        <el-col class="backend-top" :span="24">
            <h1>
                <span>MeEdu.TV</span>
                <el-dropdown class="administrator">
                  <span class="el-dropdown-link">
                    {{ Auth::guard('administrator')->user()->name }} <i class="el-icon-arrow-down el-icon--right"></i>
                  </span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>
                            <a href="">修改密码</a>
                        </el-dropdown-item>
                        <el-dropdown-item>
                            <a href="">安全退出</a>
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </h1>
        </el-col>
        <el-col class="backend-left" :span="4">
            <ul>
                <li><a href="">主面板</a></li>
            </ul>
        </el-col>
        <el-col class="backend-body" :span="20">
            @yield('app')
        </el-col>
    </el-row>
</div>

<script src="{{ asset('js/app.js') }}"></script>
@include('components.flash')
@yield('js')
</body>
</html>