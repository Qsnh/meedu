@extends('layouts.app')

@section('content')

    @include('components.frontend.bind_mobile_alert')

    <header class="header bg-img" style="background-image: url('/frontend/assets/img/bg/user-banner.jpg')">
        <div class="header-info h-250px mb-0">
            <div class="media align-items-end">
                <a href="{{route('member.avatar')}}"><img class="avatar avatar-xl avatar-bordered" src="{{$user['avatar']}}"></a>
                <div class="media-body">
                    <p class="text-white"><strong>{{$user['nick_name']}}</strong></p>
                    <small class="text-white">
                        @if($user['role'] ?? [])
                            <span class="badge badge-primary"><b>{{$user['role']['name']}}</b></span>
                            <span class="ml-2">还剩下{{\Carbon\Carbon::parse($user['role_expired_at'])->diffInDays()}}天</span>
                            @else
                            <span class="badge badge-default">免费会员</span>
                        @endif
                    </small>
                </div>
            </div>
        </div>

        <div class="header-action bg-white">
            <nav class="nav">
                <a class="nav-link {{menu_active('member')}}" href="{{ route('member') }}"><i class="fa fa-dashboard"></i> 会员中心</a>
                <a class="nav-link {{menu_active('member.orders')}}" href="{{ route('member.orders') }}"><i class="fa fa-reorder"></i> 我的订单</a>
                <a class="nav-link {{menu_active('member.courses')}}" href="{{ route('member.courses') }}"><i class="fa fa-cloud"></i> 我的课程</a>
                <a class="nav-link {{menu_active('member.course.videos')}}" href="{{ route('member.course.videos') }}"><i class="fa fa-file-video-o"></i> 我的视频</a>
                <a class="nav-link {{menu_active('member.join_role_records')}}" href="{{ route('member.join_role_records') }}"><i class="fa fa-user-secret"></i> 订阅计划</a>
                <a class="nav-link {{menu_active('member.socialite')}}" href="{{ route('member.socialite') }}"><i class="fa fa-weixin"></i> 快捷登录</a>
                <a class="nav-link {{menu_active('member.promo_code')}}" href="{{ route('member.promo_code') }}"><i class="fa fa-users"></i> 我的优惠码</a>
                <a class="nav-link {{menu_active('member.password_reset')}}" href="{{ route('member.password_reset') }}"><i class="fa fa-unlock-alt"></i> 修改密码</a>
            </nav>
        </div>
    </header>

    @yield('member')

@endsection