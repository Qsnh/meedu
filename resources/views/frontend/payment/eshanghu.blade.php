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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-4 text-center pay">
                <p>请扫描下方二维码支付</p>
                <p>{!! QrCode::size(300)->generate($codeUrl) !!}</p>
                <p class="lh-30"><b>￥{{$order->charge}}</b></p>
                <p>
                    <a class="btn btn-primary" href="{{route('member.orders')}}">支付成功</a>
                    <a class="btn btn-outline-primary" href="{{route('member.orders')}}">取消支付</a>
                </p>
            </div>
        </div>
    </div>

@endsection