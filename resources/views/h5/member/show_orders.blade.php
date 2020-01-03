@extends('h5.app-notab')

@section('content')

    @forelse($orders as $order)
        <div class="weui-form-preview" style="margin-bottom: 14px;">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">付款金额</label>
                    <em class="weui-form-preview__value">¥{{ $order['charge'] }}</em>
                </div>
            </div>
            <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">商品</label>
                    <span class="weui-form-preview__value">{{ implode(',', array_column($order['goods'] ?? [], 'goods_text')) }}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">时间</label>
                    <span class="weui-form-preview__value">{{ $order['created_at'] }}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">状态</label>
                    <span class="weui-form-preview__value">{{$order['status_text']}}</span>
                </div>
            </div>
        </div>
    @empty
        @include('h5.components.none')
    @endforelse

@endsection