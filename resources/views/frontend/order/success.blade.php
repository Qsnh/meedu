@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>支付成功</strong>
            </h1>
        </div>
    </header>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center" style="min-height: 400px;">
                <p class="mt-5 mb-5 text-primary">
                    <i class="fa fa-check fa-5x" aria-hidden="true"></i>
                </p>
                <p>订单号：{{$order['order_id']}}</p>
                <p><a class="btn btn-primary" href="{{route('member.orders')}}">我的订单</a></p>
            </div>
        </div>
    </div>

@endsection