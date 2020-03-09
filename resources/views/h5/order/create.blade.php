@extends('layouts.h5')

@section('content')

    @include('h5.components.topbar', ['back' => route('member'), 'backText' => '会员中心', 'title' => '购物车'])

    <form action="" method="post" class="create-order-form">
        @csrf
        <input type="hidden" name="goods_id" value="{{$goods['id']}}">
        <div class="container-fluid bg-fff" style="margin-top: 80px;">
            <div class="row">
                <div class="col-12 py-4">
                    <div class="goods-name">
                        <b>商品名：</b>
                        <span>{{$goods['title']}}</span>
                    </div>
                    <div class="goods-price">
                        <b>总价：</b>
                        <span class="price"><small>￥</small>{{$goods['charge']}}</span>
                    </div>
                    <div class="goods-price">
                        <b>邀请码抵扣：</b>
                        <span class="price"><small>￥</small><span class="promo-code-price">0</span></span>
                    </div>
                    <div class="promo-code">
                        <div class="input-group">
                            <input type="hidden" name="promo_code_id" value="">
                            <input type="text" name="promo_code" class="form-control promo-code-input"
                                   placeholder="邀请码">
                            <div class="input-group-append">
                                <button data-url="{{route('ajax.promo_code.check')}}"
                                        class="btn btn-primary promo-code-check-button" type="button">检测
                                </button>
                            </div>
                        </div>
                        <div class="promo-code-info"></div>
                    </div>
                    <div class="payments">
                        <input type="hidden" name="payment_scene" value="{{$scene}}">
                        <input type="hidden" name="payment_sign" value="">
                        <p><b>请选择支付方式：</b></p>
                        @foreach($payments as $payment)
                            <div class="payment-item">
                                <img src="{{$payment['logo']}}" width="170" height="60"
                                     data-payment="{{$payment['sign']}}">
                            </div>
                        @endforeach
                    </div>
                    <div class="info">
                        <p class="text-right">
                            需支付 <span class="total"><small>￥</small><span
                                        data-total="{{$goods['charge']}}"
                                        class="total-price-val">{{$goods['charge']}}</span></span>
                        </p>
                    </div>
                    <div class="pay-button-box text-right">
                        <button type="submit" class="btn btn-primary pay-button">确认支付</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection