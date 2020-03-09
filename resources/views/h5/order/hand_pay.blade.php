@extends('layouts.h5')

@section('content')

    @include('h5.components.topbar', ['back' => route('member'), 'backText' => '会员中心', 'title' => '收银台'])

    <div class="container-fluid py-3 bg-fff my-5">
        <div class="row">
            <div class="col-12">
                <h3>手动支付</h3>
                <p class="mt-4">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                <p>支付总额 <span class="ml-3">￥{{$needPaidTotal}}</span></p>
            </div>
            <div class="col-12">
                {!! $intro !!}
            </div>
        </div>
    </div>

@endsection