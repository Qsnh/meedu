@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>微信支付</strong>
            </h1>
        </div>
    </header>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center" style="min-height: 400px;">
                <p>订单号：{{$order['order_id']}}</p>
                <p>支付金额：￥{{$order['charge']}}</p>
                <p class="mt-5 mb-5">
                    {!! QrCode::size(300)->generate($qrcodeUrl); !!}
                </p>
                <p>
                    <a class="btn btn-primary" href="{{route('member.orders')}}">支付成功</a>
                    <a class="btn btn-outline-primary" href="{{route('member.orders')}}">取消支付</a>
                </p>
            </div>
        </div>
    </div>

@endsection