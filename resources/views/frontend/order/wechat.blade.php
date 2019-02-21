@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>微信支付</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center" style="min-height: 400px;">
                <p>订单号：{{$order->order_id}}</p>
                <p>支付金额：￥{{$order->charge}}</p>
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