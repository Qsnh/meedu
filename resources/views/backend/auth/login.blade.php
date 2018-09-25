<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MeEDU后台管理系统</title>
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
</head>
<body>

<div id="app">
    <el-row>
        <el-col :span="20" :offset="2">
            <h1 class="login-page-logo" style="color: #409EFF">MeEdu</h1>
        </el-col>
        <el-col :span="8" :offset="8" style="margin-top: 50px;">
            <h3 style="text-align: center">登录</h3>
            <el-form label-position="top" method="post">
                {!! csrf_field() !!}
                <el-form-item label="邮箱">
                    <el-input name="email" value="{{ old('email') }}" placeholder="请输入邮箱"></el-input>
                </el-form-item>
                <el-form-item label="密码">
                    <el-input name="password" type="password" placeholder="请输入密码"></el-input>
                </el-form-item>
                <el-button type="primary" native-type="submit" style="float: right">登录</el-button>
            </el-form>
        </el-col>
        <el-col class="login-page-footer" :span="20" :offset="2">
            <p>
                CopyRight <a href="https://meedu.tv">MeEdu</a> 2018.
                <a href="https://github.com/Qsnh/meedu">Github</a>
            </p>
        </el-col>
    </el-row>
</div>

<script src="{{ asset('js/backend.js') }}"></script>
<script>
    var vm = new Vue({
        el: '#app',
        data: function () {
            return {
                messageSuccess: '{{ get_first_flash('success') }}',
                messageWarning: '{{ get_first_flash('warning') }}',
                messageError: '{{ get_first_flash('errors') }}'
            }
        },
        created: function () {
            if (this.messageSuccess) {
                this.$message.success(this.messageSuccess);
                return;
            }
            if (this.messageWarning) {
                this.$message.warning(this.messageWarning);
                return;
            }
            if (this.messageError) {
                this.$message.warning(this.messageError);
                return;
            }
        }
    });
</script>
</body>
</html>