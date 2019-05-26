<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="blank, starter">
    <title>@yield('title') MeEdu后台管理系统</title>
    <!-- Styles -->
    <link href="{{asset('/theadmin/dist/assets/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('/theadmin/dist/assets/css/app.min.css')}}" rel="stylesheet">
    <link href="{{asset('/theadmin/dist/assets/css/style.min.css')}}" rel="stylesheet">
    @yield('css')
</head>
<body>

@yield('base')

<!-- Scripts -->
<script src="{{asset('/theadmin/dist/assets/js/core.min.js')}}" data-provide="sweetalert"></script>
<script src="{{asset('/theadmin/dist/assets/js/app.min.js')}}"></script>
<script src="{{asset('/theadmin/dist/assets/js/script.min.js')}}"></script>
<script>
    app.ready(function () {
        @if(get_first_flash('success'))
        swal('成功', "{{get_first_flash('success')}}", 'success');
        @endif
        @if(get_first_flash('warning'))
        swal('警告', "{{get_first_flash('warning')}}", 'warning');
        @endif
        @if(get_first_flash('error'))
        swal('失败', "{{get_first_flash('error')}}", 'error');
        @endif
    });
</script>
@yield('js')
</body>
</html>