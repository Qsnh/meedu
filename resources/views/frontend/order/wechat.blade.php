@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12 bg-fff br-8 px-5 py-4">
                <div class="w-100 float-left">
                    <div class="row">
                        <div class="col-12">
                            <h2>微信支付</h2>
                        </div>
                        <div class="col-12">
                            <p class="mt-4">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                            <p>支付总额 <span class="ml-3">￥{{$needPaidTotal}}</span></p>
                        </div>
                        <div class="col-12 py-3 text-center">
                            {!! QrCode::size(300)->generate($qrcodeUrl); !!}
                            <p>请使用微信扫一扫支付</p>
                        </div>
                        <div class="col-12 text-right">
                            <a href="{{route('member.orders')}}" class="btn btn-primary">支付完成</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection