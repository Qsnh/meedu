@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 mt-20 mb-20 lg:max-w-6xl lg:mx-auto">
        <div class="flex justify-center">
            <div class="w-full lg:w-96">
                <div class="bg-white rounded p-5 shadow">
                    <div class="text-2xl font-bold text-gray-800 mb-2 text-center mt-5">{{__('微信扫码登录')}}</div>
                    <div class="text-gray-500 text-sm text-center mb-5">{{__('请使用微信扫码下方二维码登录')}}</div>
                    <div class="mb-5 text-center">
                        <img src="{{$image}}" class="inline object-cover" width="300" height="300">
                    </div>
                    <div class="text-center text-gray-500 text-sm">
                        <span>{{__('登录即代表您同意')}}</span>
                        <a target="_blank" class="text-blue-600"
                           href="{{route('user.protocol')}}">{{__('《用户协议》')}}</a>
                        <span>,</span>
                        <a target="_blank" class="text-blue-600"
                           href="{{route('user.private_protocol')}}">{{__('《用户隐私协议》')}}</a>
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