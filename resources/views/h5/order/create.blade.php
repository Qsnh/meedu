@extends('layouts.h5-pure')

@section('css')
    <style>
        body {
            padding-bottom: 49px;
        }
    </style>
@endsection

@section('content')

    @include('h5.components.topbar', ['title' => '收银台', 'back' => route('index'), 'class' => 'dark'])

    <form action="" method="post" class="create-order-form">
        @csrf
        <input type="hidden" name="goods_id" value="{{$goods['id']}}">
        <div class="box" style="margin-bottom: 110px;">
            <div class="page-title">订阅信息</div>
            <div class="goods-info-box">
                <div class="goods-thumb">
                    <img src="{{$goods['thumb']}}" width="165" height="125">
                </div>
                <div class="goods-info">
                    <div class="title">{{$goods['title']}}</div>
                    <div class="goods-labels">
                        <span class="label">{{$goods['label']}}</span>
                    </div>
                </div>
            </div>
            <div class="promo-code">
                <div class="title">
                    邀请码/优惠码
                    <small>（选填）</small>
                </div>
                <div class="input">
                    <input type="hidden" name="promo_code_id" value="">
                    <input type="text" name="promo_code" class="promo-code-input">
                    <a href="javascript:void(0)" class="promo-code-check-button"
                       data-url="{{route('ajax.promo_code.check')}}">验证</a>
                </div>
                <div class="promo-code-info"></div>
            </div>
            <div class="payments">
                <div class="page-title">支付方式</div>
                <div class="payments-item">
                    <input type="hidden" name="payment_scene" value="{{$scene}}">
                    <input type="hidden" name="payment_sign" value="{{$payments->isNotEmpty() ? $payments->first()['sign'] : ''}}">
                    @foreach($payments as $payment)
                        <a href="javascript:void(0)" class="payment-item {{$loop->first ? 'active' : ''}}"
                           data-payment="{{$payment['sign']}}">
                            <img src="{{$payment['logo']}}" width="85" height="30">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </form>


    <div class="pay-button-box">
        <div class="pay-info">
            <div class="promo-code-price">邀请码抵扣 <span class="promo-code-price-text">0</span> 元</div>
            <div class="price">
                <small>￥</small>
                <span class="total-price" data-total="{{$goods['charge']}}">{{$goods['charge']}}</span>
            </div>
        </div>
        <a href="javascript:void(0)" class="pay-button focus-c-white">
            立即支付
        </a>
    </div>

@endsection