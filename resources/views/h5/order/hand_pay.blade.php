@extends('h5.app')

@section('css')
    <style>
        .content img {
            max-width: 100%;
        }
    </style>
@endsection

@section('content')

    <div class="weui-flex">
        <div class="weui-flex__item">
            <h3 style="padding-top: 50px; padding-bottom: 50px; padding-left: 20px;">
                手动打款
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

    <br><br>

    <div class="weui-flex bg-fff">
        <div class="weui-flex__item content" style="padding: 10px;">
            {!! $intro !!}
        </div>
    </div>

@endsection