@extends('h5.app')

@section('content')

    @foreach($roles as $role)
        <div class="weui-form-preview" style="margin-bottom: 14px;">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">{{$role['name']}}</label>
                    <em class="weui-form-preview__value">¥{{$role['charge']}}</em>
                </div>
            </div>
            <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">时间</label>
                        <span class="weui-form-preview__value">{!! nl2br($role['description']) !!}</span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">天数</label>
                        <span class="weui-form-preview__value">{{ $role['expire_days'] }}</span>
                    </div>
                </div>
            </div>
            <div class="weui-form-preview__ft">
                <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="{{route('member.role.buy', [$role['id']])}}">购买</a>
            </div>
        </div>
    @endforeach

@endsection