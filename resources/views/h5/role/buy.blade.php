@extends('h5.app')

@section('content')

    <div class="weui-flex">
        <div class="weui-flex__item">
            <h3 style="padding-top: 50px; padding-bottom: 50px; padding-left: 20px;">
                购买 <b>{{$role['name']}}</b>
            </h3>
        </div>
    </div>

    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">付款金额</label>
                <em class="weui-form-preview__value">¥{{$role['charge']}}</em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">内容</label>
                <span class="weui-form-preview__value">{!! nl2br($role['description']) !!}</span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">天数</label>
                <span class="weui-form-preview__value">{{$role['expire_days']}}</span>
            </div>
        </div>
        <div class="weui-form-preview__ft">
            <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:"
               onclick="$('#submit').click()">确认订单</a>
        </div>
    </div>

    <form action="" method="post">
        @csrf
        <button type="submit" id="submit"></button>
    </form>

@endsection