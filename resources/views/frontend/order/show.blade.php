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
                @if($payments->isEmpty())
                <p class="mt-3">
                    暂无支付渠道，请联系站长手动处理【联系方式见页面下方】。
                </p>
                    @else
                    <form action="{{route('order.pay', [$order->order_id])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>请选择支付方式</label>
                            <select name="payment" class="form-control">
                                @foreach($payments as $payment)
                                <option value="{{$payment['sign']}}">{{$payment['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">立即支付</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

@endsection