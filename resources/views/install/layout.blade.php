<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link crossorigin="anonymous" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" href="https://lib.baomitu.com/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <title>MeEdu安装程序</title>
</head>
<body>

    <div class="container-fluid mb-3">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-center" style="line-height: 160px;">MeEdu安装程序</h2>
            </div>
        </div>
    </div>

    @if($errors->any())
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-warning">
                    @foreach($errors->all() as $error)
                        <p style="margin: 0px; padding: 0px;">{{$error}}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    @yield('content')

</body>
</html>