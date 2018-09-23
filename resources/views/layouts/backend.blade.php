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
    <link href="{{ asset('css/backend_diy.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>

<div id="app">

    <header class="backend-header">
        <el-row>
            <el-col :span="12">
                <span class="backend-header-logo">MeEdu</span>
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
                <dt>运营</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.announcement.index') }}">
                            <a href="{{ route('backend.announcement.index') }}">公告</a>
                        </li>
                        <li class="{{ menu_is_active('backend.role.index') }}">
                            <a href="{{ route('backend.role.index') }}">VIP会员</a>
                        </li>
                        <li class="{{ menu_is_active('backend.subscription.email') }}">
                            <a href="{{ route('backend.subscription.email') }}">邮件群发</a>
                        </li>
                    </ul>
                </dd>
                <dt>财务</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.recharge') }}">
                            <a href="{{ route('backend.recharge') }}">充值记录</a>
                        </li>
                    </ul>
                </dd>
                <dt>会员</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.member.index') }}">
                            <a href="{{ route('backend.member.index') }}">会员</a>
                        </li>
                    </ul>
                </dd>
                <dt>视频</dt>
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
                <dt>FAQ</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.faq.category.index') }}">
                            <a href="{{ route('backend.faq.category.index') }}">分类</a>
                        </li>
                        <li class="{{ menu_is_active('backend.faq.article.index') }}">
                            <a href="{{ route('backend.faq.article.index') }}">文章</a>
                        </li>
                    </ul>
                </dd>
                <dt>系统</dt>
                <dd>
                    <ul>
                        <li class="{{ menu_is_active('backend.setting.index') }}">
                            <a href="{{ route('backend.setting.index') }}">全站配置</a>
                        </li>
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

<div id="app1"></div>

<script src="{{ asset('js/backend.js') }}"></script>
@yield('js')
<script>
    new Vue({
        el: '#app1',
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