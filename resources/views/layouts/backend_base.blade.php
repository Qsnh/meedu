<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="blank, starter">
    <title>@yield('title') MeEdu后台管理系统</title>
    <!-- Fonts -->
    <style>
        /* roboto-100 */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 100;
            src: url('//lib.baomitu.com/fonts/roboto/roboto-100.eot'); /* IE9 Compat Modes */
            src: local('Roboto'), local('Roboto-Normal'),
            url('//lib.baomitu.com/fonts/roboto/roboto-100.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/roboto/roboto-100.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-100.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-100.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/roboto/roboto-100.svg#Roboto') format('svg'); /* Legacy iOS */
        }

        /* roboto-300 */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 300;
            src: url('//lib.baomitu.com/fonts/roboto/roboto-300.eot'); /* IE9 Compat Modes */
            src: local('Roboto'), local('Roboto-Normal'),
            url('//lib.baomitu.com/fonts/roboto/roboto-300.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/roboto/roboto-300.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-300.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-300.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/roboto/roboto-300.svg#Roboto') format('svg'); /* Legacy iOS */
        }

        /* roboto-regular */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: regular;
            src: url('//lib.baomitu.com/fonts/roboto/roboto-regular.eot'); /* IE9 Compat Modes */
            src: local('Roboto'), local('Roboto-Normal'),
            url('//lib.baomitu.com/fonts/roboto/roboto-regular.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/roboto/roboto-regular.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-regular.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-regular.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/roboto/roboto-regular.svg#Roboto') format('svg'); /* Legacy iOS */
        }

        /* roboto-500 */
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            src: url('//lib.baomitu.com/fonts/roboto/roboto-500.eot'); /* IE9 Compat Modes */
            src: local('Roboto'), local('Roboto-Normal'),
            url('//lib.baomitu.com/fonts/roboto/roboto-500.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/roboto/roboto-500.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-500.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-500.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/roboto/roboto-500.svg#Roboto') format('svg'); /* Legacy iOS */
        }

        /* roboto-300italic */
        @font-face {
            font-family: 'Roboto';
            font-style: italic;
            font-weight: 300;
            src: url('//lib.baomitu.com/fonts/roboto/roboto-300italic.eot'); /* IE9 Compat Modes */
            src: local('Roboto'), local('Roboto-Italic'),
            url('//lib.baomitu.com/fonts/roboto/roboto-300italic.eot?#iefix') format('embedded-opentype'), /* IE6-IE8 */
            url('//lib.baomitu.com/fonts/roboto/roboto-300italic.woff2') format('woff2'), /* Super Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-300italic.woff') format('woff'), /* Modern Browsers */
            url('//lib.baomitu.com/fonts/roboto/roboto-300italic.ttf') format('truetype'), /* Safari, Android, iOS */
            url('//lib.baomitu.com/fonts/roboto/roboto-300italic.svg#Roboto') format('svg'); /* Legacy iOS */
        }
    </style>
    <!-- Styles -->
    <link href="{{asset('/theadmin/src/assets/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('/theadmin/src/assets/css/app.min.css')}}" rel="stylesheet">
    <link href="{{asset('/theadmin/src/assets/css/style.min.css')}}" rel="stylesheet">
    @yield('css')
</head>
<body>

@yield('base')

<!-- Scripts -->
<script src="{{asset('/theadmin/src/assets/js/core.min.js')}}"></script>
<script src="{{asset('/theadmin/src/assets/js/app.min.js')}}"></script>
<script src="{{asset('/theadmin/src/assets/js/script.min.js')}}"></script>
<script>
    @if(get_first_flash('success'))
    app.toast("{{get_first_flash('success')}}");
    @endif
    @if(get_first_flash('warning'))
    app.toast("{{get_first_flash('warning')}}");
    @endif
    @if(get_first_flash('error'))
    app.toast("{{get_first_flash('error')}}");
    @endif
</script>
@yield('js')
</body>
</html>