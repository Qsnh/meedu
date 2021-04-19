@extends('layouts.app')

@section('content')

    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 my-5">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 bg-fff pt-5 pb-3 px-5 br-8 box-shadow1 fs-14px">
                            <h3 class="text-center">微信扫码登录</h3>
                            <div class="text-center mb-3" style="color: rgba(0,0,0,.5)">(请使用微信扫描下方二维码)</div>
                            <div class="text-center">
                                <img src="{{$image}}" width="300" height="300">
                            </div>
                            <div class="text-center">
                                登录即代表您同意 <a target="_blank" href="{{route('user.protocol')}}"><b>用户协议</b></a> 和 <a
                                        target="_blank"
                                        href="{{route('user.private_protocol')}}"><b>用户隐私协议</b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var queryHandler = function () {
            var code = '{{$code}}';
            $.getJSON('{{route('login.wechat.scan.query')}}?code=' + code, function (res) {
                if (res.code !== 0) {
                    flashError(res.message);
                } else {
                    if (res.data.status === 1) {
                        // 登录成功
                        window.location.href = res.data.redirect_url;
                    }
                }
            });
        }
        setInterval(queryHandler, 1000);
    </script>

@endsection