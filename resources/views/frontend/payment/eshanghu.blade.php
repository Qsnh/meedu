@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>收银台</strong>
            </h1>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center pay">
                <p>请使用微信扫描下方二维码支付</p>
                <p class="mt-5 mb-5">{!! QrCode::size(300)->generate($codeUrl) !!}</p>
                <p class="lh-30"><b>￥{{$order->charge}}</b></p>
                <p>
                    <a class="btn btn-primary" href="{{route('member.orders')}}">支付成功</a>
                    <a class="btn btn-outline-primary" href="{{route('member.orders')}}">取消支付</a>
                </p>
            </div>
        </div>
    </div>

@endsection