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
            <div class="col-sm-4 text-center" style="min-height: 400px;">
                <p>订单号：{{$order->order_id}} ￥{{$order->charge}}</p>
                <p style="margin-top: 15px;">
                    暂无支付渠道，请联系站长手动开通【联系方式见页面下方】。
                </p>
            </div>
        </div>
    </div>

@endsection