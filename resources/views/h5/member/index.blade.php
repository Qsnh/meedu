@extends('layouts.h5-pure')

@section('css')
    <style>
        body {
            background-color: rgba(0, 0, 0, .04);
        }
    </style>
@endsection

@section('content')

    <div class="user-detail-page">
        <div class="user-info-box">
            <div class="avatar">
                <img src="{{$user['avatar']}}" width="60" height="60">
            </div>
            <div class="info">
                <div class="nickname">{{$user['nick_name']}}</div>
                <div class="stat">
                    <span>积分 <b>{{$user['credit1']}}</b></span>
                </div>
            </div>
        </div>

        <div class="user-menus">
            <div class="body">
                <a href="{{route('member.courses')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                    </div>
                    <div class="text">我的课程</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
                <a href="{{route('member.orders')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                    </div>
                    <div class="text">我的订单</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
                <a href="{{route('member.credit1_records')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-diamond" aria-hidden="true"></i>
                    </div>
                    <div class="text">我的积分</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
                <a href="{{route('member.promo_code')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <div class="text">我的邀请</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
                <a href="{{route('member.messages')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-comments" aria-hidden="true"></i>
                    </div>
                    <div class="text">我的消息</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
            </div>
        </div>

        <div class="user-menus">
            <div class="body">
                <a href="{{route('aboutus')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </div>
                    <div class="text">关于我们</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
                <a href="{{route('user.protocol')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </div>
                    <div class="text">用户协议</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
                <a href="{{route('user.private_protocol')}}" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </div>
                    <div class="text">用户协议</div>
                    <div class="right-menu">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </div>
                </a>
                <a href="" class="menu-item">
                    <div class="icon">
                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                    </div>
                    <div class="text">安全退出</div>
                </a>
            </div>
        </div>
    </div>

    @include('h5.components.tabbar', ['active' => 'user'])

@endsection