@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>收银台</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center">
                <p>订单号：{{$order->order_id}} ￥{{$order->charge}}</p>
                <p style="margin-top: 15px;">
                    <img src="{{$pay['pay_qr_code']}}" width="100%">
                </p>
                <p style="margin-top: 15px;">
                    <a href="{{route('member.orders')}}" class="btn btn-success btn-block">支付成功</a>
                </p>
                <p style="margin-top: 10px;">
                    <a href="{{route('member')}}" class="btn btn-secondary btn-block">取消支付</a>
                </p>
            </div>
        </div>
    </div>

@endsection