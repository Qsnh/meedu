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
        body { background-color: #FBFBFB; }
    </style>
</head>
<body>

<div id="app">
    <el-row>
        <el-col :span="20" :offset="2">
            <h1 style="color: #409EFF">MeEdu</h1>
        </el-col>
        <el-col :span="8" :offset="8" style="margin-top: 50px;">
            <h3 style="text-align: center">登录</h3>
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <el-form-item label="邮箱">
                    <el-input name="email" placeholder="请输入邮箱"></el-input>
                </el-form-item>
                <el-form-item label="密码">
                    <el-input name="password" type="password" placeholder="请输入密码"></el-input>
                </el-form-item>
                <el-button type="primary" native-type="submit" style="float: right">登录</el-button>
            </el-form>
        </el-col>
    </el-row>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>

</script>
</body>
</html>