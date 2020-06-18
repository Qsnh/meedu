@extends('layouts.app-active')

@section('content')

    <div class="member-menu-parent">
        <div class="container-fluid member-menu">
            <div class="container">
                <div class="row">
                    <div class="col-12 member-menu-box">
                        <a href="{{route('member')}}" class="{{menu_active('member')}}">
                            <div>
                                <img src="/images/icons/member/profile.png" width="24" height="24">
                                <span class="member-menu-item-title">我的资料</span>
                            </div>
                            <div class="dot-box">
                                <span class="dot"></span>
                            </div>
                        </a>
                        <a href="{{route('member.courses')}}" class="{{menu_active('member.courses')}}">
                            <div>
                                <img src="/images/icons/member/course.png" width="24" height="24">
                                <span class="member-menu-item-title">我的课程</span>
                            </div>
                            <div class="dot-box">
                                <span class="dot"></span>
                            </div>
                        </a>
                        <a href="{{route('member.orders')}}" class="{{menu_active('member.orders')}}">
                            <div>
                                <img src="/images/icons/member/order.png" width="24" height="24">
                                <span class="member-menu-item-title">订单信息</span>
                            </div>
                            <div class="dot-box">
                                <span class="dot"></span>
                            </div>
                        </a>
                        <a href="{{route('member.promo_code')}}" class="{{menu_active('member.promo_code')}}">
                            <div>
                                <img src="/images/icons/member/invite.png" width="24" height="24">
                                <span class="member-menu-item-title">我的邀请码</span>
                            </div>
                            <div class="dot-box">
                                <span class="dot"></span>
                            </div>
                        </a>
                        <a href="{{route('member.credit1_records')}}" class="{{menu_active('member.credit1_records')}}">
                            <div>
                                <img src="/images/icons/member/credit1.png" width="24" height="24">
                                <span class="member-menu-item-title">我的积分</span>
                            </div>
                            <div class="dot-box">
                                <span class="dot"></span>
                            </div>
                        </a>
                        <a href="{{route('member.messages')}}" class="{{menu_active('member.messages')}}">
                            <div>
                                <img src="/images/icons/member/message.png" width="24" height="24">
                                <span class="member-menu-item-title">我的消息</span>
                            </div>
                            <div class="dot-box">
                                <span class="dot"></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('member')

@endsection