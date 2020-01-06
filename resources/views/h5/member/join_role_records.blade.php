@extends('h5.app-notab')

@section('content')

    @forelse($records as $record)
        <div class="weui-form-preview" style="margin-bottom: 14px;">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">付款金额</label>
                    <em class="weui-form-preview__value">¥{{ $record['charge'] }}</em>
                </div>
            </div>
            <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">套餐</label>
                    <span class="weui-form-preview__value">{{$record['role']['name']}}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">开始时间</label>
                    <span class="weui-form-preview__value">{{$record['started_at']}}</span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">结束时间</label>
                    <span class="weui-form-preview__value">{{$record['expired_at']}}</span>
                </div>
            </div>
        </div>
    @empty
        @include('h5.components.none')
    @endforelse

@endsection