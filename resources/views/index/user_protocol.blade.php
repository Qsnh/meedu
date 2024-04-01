@if(mb_substr($protocol, -7,7) === '</html>')
{!! $protocol !!}
@else
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('用户协议')}}</title>
</head>
<body>
{!! $protocol !!}
</body>
</html>
@endif

