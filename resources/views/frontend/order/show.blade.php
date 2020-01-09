@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>收银台</strong>
            </h1>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{route('order.pay', [$order['order_id']])}}" class="card" method="post">
                    @csrf
                    <h4 class="card-title"><strong>订单号：{{$order['order_id']}} | ￥{{$needPaidTotal}}</strong></h4>
                    <div class="card-body">
                        <h6>请选择支付方式</h6>
                        <br>
                        @foreach($payments as $index => $payment)
                            <div class="flexbox">
                                <div>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="payment" value="{{$payment['sign']}}" {{$index == 0 ? 'checked' : ''}}>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"><strong>{{$payment['name']}}</strong></span>
                                    </label>
                                </div>
                                {{--<div>--}}
                                    {{--<img src="../assets/img/icon/paypal.png" alt="...">--}}
                                {{--</div>--}}
                            </div>
                            <br>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary">继续支付 <i class="ti-arrow-right ml-2 fs-9"></i></button>
                </form>
            </div>
        </div>
    </div>

@endsection