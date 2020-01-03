@extends('h5.app')

@section('content')

    <div class="weui-flex">
        <div class="weui-flex__item">
            <h3 style="padding-top: 50px; padding-bottom: 50px; padding-left: 20px;">
                收银台
            </h3>
        </div>
    </div>

    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">付款金额</label>
                <em class="weui-form-preview__value">¥{{$order['charge']}}</em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">订单号</label>
                <span class="weui-form-preview__value">{{$order['order_id']}}</span>
            </div>
        </div>
    </div>

    <form action="{{route('order.pay', [$order['order_id']])}}" method="post">
        @csrf
        <div class="weui-flex">
            <div class="weui-flex__item">
                <div class="weui-form__control-area">
                    <div class="weui-cells__group weui-cells__group_form">
                        <div class="weui-cells__title">请选择支付方式</div>
                        @foreach($payments as $index => $payment)
                            <div class="weui-cells weui-cells_radio">
                                <label class="weui-cell weui-check__label" for="payment-{{$payment['sign']}}">
                                    <div class="weui-cell__bd">
                                        <p>{{$payment['name']}}</p>
                                    </div>
                                    <div class="weui-cell__ft">
                                        <input type="radio" class="weui-check" name="payment" value="{{$payment['sign']}}"
                                               id="payment-{{$payment['sign']}}">
                                        <span class="weui-icon-checked"></span>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="weui-form__opr-area">
                    <button class="weui-btn weui-btn_primary" type="submit">支付</button>
                </div>
            </div>
        </div>
    </form>

@endsection