@extends('layouts.app')

@section('css')
    <style>
        body {
            background-color: #f6f6f6;
        }
    </style>
@endsection

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 user-banner">
                <div class="float-left w-100 bg-dark py-3 px-3 br-top-8">
                    <a href="{{route('member.avatar')}}"><img src="{{$user['avatar']}}" width="70" height="70" class="br-50"></a>
                    <span class="c-fff ml-3">{{$user['nick_name']}}</span>
                    @if($user['role'] ?? [])
                        <span class="badge badge-success p-2 ml-2"><b>{{$user['role']['name']}}</b></span>
                    @else
                        <span class="badge badge-default">免费会员</span>
                    @endif
                </div>
            </div>
            <div class="col-12">
                <div class="float-left w-100 py-2 px-3 user-banner-menu br-bottom-8">
                    <a class="{{menu_active('member')}}" href="{{ route('member') }}">
                        <i class="fa fa-dashboard"></i> 会员中心
                    </a>
                    <a class="{{menu_active('member.orders')}}" href="{{ route('member.orders') }}">
                        <i class="fa fa-reorder"></i> 我的订单
                    </a>
                    <a class="{{menu_active('member.courses')}}" href="{{ route('member.courses') }}">
                        <i class="fa fa-cloud"></i> 我的课程
                    </a>
                    <a class="{{menu_active('member.course.videos')}}"
                       href="{{ route('member.course.videos') }}">
                        <i class="fa fa-file-video-o"></i> 我的视频
                    </a>
                    <a class="{{menu_active('member.join_role_records')}}"
                       href="{{ route('member.join_role_records') }}">
                        <i class="fa fa-user-secret"></i> 订阅计划
                    </a>
                    <a class="{{menu_active('member.socialite')}}" href="{{ route('member.socialite') }}">
                        <i class="fa fa-link"></i> 快捷登录
                    </a>
                    <a class="{{menu_active('member.promo_code')}}" href="{{ route('member.promo_code') }}">
                        <i class="fa fa-users"></i> 我的优惠码
                    </a>
                    <a class="{{menu_active('member.password_reset')}}"
                       href="{{ route('member.password_reset') }}">
                        <i class="fa fa-unlock-alt"></i> 修改密码
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(app()->make(\App\Businesses\BusinessState::class)->isNeedBindMobile($user))
        <div class="container mt-5">
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle"></i> 请绑定手机号 <a href="{{route('member.mobile.bind')}}">点我绑定</a>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @yield('member')

@endsection