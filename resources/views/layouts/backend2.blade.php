<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MeEDU后台管理系统</title>
    <link href="{{ mix('css/backend.css') }}" rel="stylesheet">
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
                @foreach(backend_menus() as $menu)
                <dt>{{$menu->name}}</dt>
                <dd>
                    <ul>
                        @foreach($menu->children as $child)
                        <li>
                            <a href="{{$child->url}}">{{$child->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </dd>
                @endforeach
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

<script src="{{ mix('js/backend.js') }}"></script>
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