@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12 bg-fff br-8 px-5 py-4">
                <div class="w-100 float-left">
                    <div class="row">
                        <div class="col-12">
                            <h2>手动打款</h2>
                        </div>
                        @if($needPaidTotal > 0)
                        <div class="col-12">
                            <p class="mt-4">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                            <p>需支付总额 <span class="ml-3">￥{{$needPaidTotal}}</span></p>
                        </div>
                        @else
                            <div class="col-12">
                                <p class="mt-4">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                                <p>已支付</p>
                            </div>
                            @endif
                        <div class="col-12 py-3">
                            {!! $intro !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection