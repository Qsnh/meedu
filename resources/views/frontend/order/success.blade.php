@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>支付成功</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center" style="min-height: 400px;">
                <p class="mt-5 mb-5" style="color: green">
                    <i class="fa fa-check fa-5x" aria-hidden="true"></i>
                </p>
                <p>订单号：{{$order->order_id}}</p>
                <p>支付金额：￥{{$order->charge}}</p>
                <p><a class="btn btn-primary" href="{{route('member.orders')}}">我的订单</a></p>
            </div>
        </div>
    </div>

@endsection