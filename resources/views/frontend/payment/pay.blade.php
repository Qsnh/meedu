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
                <p><img src="{{$pay['qr_code']}}" width="200" height="200"></p>
                <p class="lh-30"><b>￥{{$money}}</b></p>
                <p style="margin-top: 20px;">
                    <a href="{{ route('member') }}" class="btn btn-success btn-block">支付成功</a>
                </p>
                <p style="margin-top: 20px;">
                    <a href="{{ route('member') }}" class="btn btn-default btn-block">取消支付</a>
                </p>
            </div>
        </div>
    </div>

@endsection