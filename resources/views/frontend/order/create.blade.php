@extends('layouts.app')

@section('content')

    <form action="" method="post" class="create-order-form">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="order-create-box">
                        <div class="title">
                            订阅信息
                        </div>
                        <div class="goods-info-box">
                            <input type="hidden" name="goods_id" value="{{$goods['id']}}">
                            <div class="goods-thumb">
                                <img src="{{$goods['thumb']}}" width="160"
                                     height="120">
                            </div>
                            <div class="goods-info">
                                <div class="goods-title">{{$goods['title']}}</div>
                                <div class="goods-label">
                                    <span class="label">{{$goods['label']}}</span>
                                </div>
                            </div>
                            <div class="goods-price">
                                <span class="price"><small>￥</small>{{$goods['charge']}}</span>
                            </div>
                        </div>
                        <div class="promo-code">
                            <div class="promo-code-title">
                                邀请码
                            </div>
                            <div class="promo-code-input">
                                <input type="hidden" name="promo_code_id" value="">
                                <input type="text" placeholder="邀请码" name="promo_code" class="form-control">
                                <button type="button" class="promo-code-check-button"
                                        data-url="{{route('ajax.promo_code.check')}}">验证
                                </button>
                                <span class="promo-code-info"></span>
                            </div>
                        </div>
                        <div class="payments-box">
                            <div class="payments-title">支付方式</div>
                            <div class="payments">
                                <input type="hidden" name="payment_scene" value="{{$scene}}">
                                <input type="hidden" name="payment_sign" value="">
                                @foreach($payments as $payment)
                                    <div class="payment-item">
                                        <img src="{{$payment['logo']}}" width="170" height="60"
                                             data-payment="{{$payment['sign']}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="bottom-info">
                                <span class="time">请在30分钟内完成支付</span>
                                <span class="total-price"><small>￥</small><span class="total-price-val"
                                                                                data-total="{{$total}}">{{$total}}</span></span>
                                <span class="charge-info">邀请码已抵扣 <span class="promo-code-price">0</span> 元，需支付</span>
                            </div>
                            <div class="bottom-button-box">
                                <button class="pay-button" type="submit">确认支付</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('js')
    <script>
        $(function () {
            $('.payment-item').first().click();
        });
    </script>
@endsection