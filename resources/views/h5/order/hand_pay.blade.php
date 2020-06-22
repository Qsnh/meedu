@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '手动支付', 'back' => route('index'), 'class' => 'dark'])

    <div class="box">
        <div class="page-title">
            手动支付
        </div>
        @if($needPaidTotal > 0)
            <div>
                <p class="mt-4">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                <p>需支付总额 <span class="ml-3">￥{{$needPaidTotal}}</span></p>
            </div>
        @else
            <div>
                <p class="mt-4">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                <p>已支付</p>
            </div>
        @endif
        <div class="hand-pay-content">
            {!! $intro !!}
        </div>
    </div>

@endsection