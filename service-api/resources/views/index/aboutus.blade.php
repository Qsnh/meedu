@if(mb_substr($aboutus, -7,7) === '</html>')
{!! $aboutus !!}
@else
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('关于我们')}}</title>
</head>
<body>
{!! $aboutus !!}
</body>
</html>
@endif

