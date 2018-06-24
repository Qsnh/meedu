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
        * { padding: 0px; margin: 0px; }
        a { text-decoration: none }
        li { list-style: none; }

        header.backend-header {
            position: absolute; top: 0; left: 0; right: 0; z-index: 10;
            width: 100%; height: 80px; background-color: #409EFF;
            line-height: 80px;
        }
        header.backend-header .backend-header-logo {
            font-size: 2rem; line-height: 80px; color: #ffffff;
            margin-left: 20px;
        }
        header.backend-header .backend-header-right-section {
            text-align: right; padding-right: 20px; color: #ffffff;
        }

        section.backend-section {
            position: absolute; top: 80px; left: 0; right: 0; bottom: 0;
            width: 100%; height: auto; display: flex;
        }
        section.backend-section .backend-left-menu {
            width: 210px; height: 100%; overflow-y: auto;
            background-color: #303133; color: #ffffff;
            padding-left: 20px;
        }
        section.backend-section .backend-left-menu a {
            color: #ffffff;
        }
        section.backend-section .backend-left-menu dt {
            width: 100%; height: 40px; line-height: 40px;
            font-size: 1rem;
        }
        section.backend-section .backend-left-menu dd {
            width: 100%; height: auto; font-size: .8rem;
        }
        section.backend-section .backend-left-menu dd li {
            line-height: 26px; margin-left: 10px;
        }
        section.backend-section .backend-left-menu dd li:hover a {
            color: #409EFF;
        }
        section.backend-section .backend-left-menu dd li.active a {
            color: #409EFF;
        }

        section.backend-section .backend-body {
            flex: 1; height: 100%; overflow-y: auto;
        }
    </style>
    @yield('css')
</head>
<body>

<div id="app">

    <header class="backend-header">
        <el-row>
            <el-col :span="12">
                <span class="backend-header-logo">MeEdu.TV</span>
            </el-col>
            <el-col :span="12" class="backend-header-right-section">
                <el-dropdown class="administrator">
                  <span class="el-dropdown-link">
                    {{ Auth::guard('administrator')->user()->name }} <i class="el-icon-arrow-down el-icon--right"></i>
                  </span>
                    <el-dropdown-menu slot="dropdown">
                        <el-dropdown-item>
                            <a href="{{ route('backend.edit.password') }}">修改密码</a>
                        </el-dropdown-item>
                        <el-dropdown-item>
                            <a href="{{ route('backend.logout') }}">安全退出</a>
                        </el-dropdown-item>
                    </el-dropdown-menu>
                </el-dropdown>
            </el-col>
        </el-row>
    </header>

    <section class="backend-section">
        <div class="backend-left-menu">
            <dl>
                <dt>主面板</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.dashboard.index') }}">
                            <a href="{{ route('backend.dashboard.index') }}">主面板</a>
                        </li>
                    </ul>
                </dd>
                <dt>视频管理</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.course.index') }}">
                            <a href="{{ route('backend.course.index') }}">课程</a>
                        </li>
                        <li class="{{ menu_is_active('backend.video.index') }}">
                            <a href="{{ route('backend.video.index') }}">视频</a>
                        </li>
                    </ul>
                </dd>
                <dt>系统</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.administrator.index') }}">
                            <a href="{{ route('backend.administrator.index') }}">管理员</a>
                        </li>
                        <li class="{{ menu_is_active('backend.administrator_role.index') }}">
                            <a href="{{ route('backend.administrator_role.index') }}">角色</a>
                        </li>
                        <li class="{{ menu_is_active('backend.administrator_permission.index') }}">
                            <a href="{{ route('backend.administrator_permission.index') }}">权限</a>
                        </li>
                    </ul>
                </dd>
            </dl>
        </div>
        <div class="backend-body">
           <el-row>
               <el-col :span="24" style="padding: 10px 20px;">
                   @yield('body')
               </el-col>
           </el-row>
        </div>
    </section>

</div>

<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
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