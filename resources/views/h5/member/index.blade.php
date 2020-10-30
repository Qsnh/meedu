@extends('layouts.h5-pure')

@section('css')
    <style>
        body {
            background-color: #F2F6F9;
        }
    </style>
@endsection

@section('content')

    @if(request()->input('action') === 'setting')

        @include('h5.components.topbar', ['title' => '设置', 'back' => '?action='])

        <div class="user-menus-group" style="margin-top: 10px">
            <a href="{{route('user.protocol')}}" class="group-menu-item">用户协议</a>
            <a href="{{route('user.private_protocol')}}" class="group-menu-item">用户隐私协议</a>
        </div>

        <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();" class="logout-button">退出登录</a>
        <form class="d-none" id="logout-form" action="{{ route('logout') }}"
              method="POST"
              style="display: none;">
            @csrf
        </form>

    @else

        <div class="user-detail-page">
            <div class="user-info-box">
                <div class="avatar">
                    <img src="{{$user['avatar']}}" width="66" height="66">
                </div>
                <div class="info">
                    <div class="nickname">
                        <div class="text">
                            {{$user['nick_name']}}
                        </div>
                        <a href="?action=setting" class="setting-icon">
                            <i class="iconfont iconsetting"></i>
                        </a>
                    </div>
                    <div class="stat">
                        <span>{{$user['role'] ? $user['role']['name'] : '免费会员'}}</span>
                        <span>&nbsp;·&nbsp;</span>
                        <span>积分 <b>{{$user['credit1']}}</b></span>
                    </div>
                </div>
            </div>

            <div class="user-main-menus">
                <a class="item" href="{{route('member.orders')}}">
                    <div class="icon" style="color: #F86868"><i class="iconfont iconorder"></i></div>
                    <div class="text">订单</div>
                </a>
                <a class="item" href="{{route('member.messages')}}">
                    <div class="icon" style="color: #6DD99F"><i class="iconfont iconnews"></i></div>
                    <div class="text">消息</div>
                </a>
                <a class="item" href="{{route('member.courses')}}?scene=like">
                    <div class="icon" style="color: #FFC219"><i class="iconfont iconcollect"></i></div>
                    <div class="text">收藏</div>
                </a>
                <a class="item" href="{{route('member.courses')}}">
                    <div class="icon" style="color: #3AAFFA"><i class="iconfont icondoc"></i></div>
                    <div class="text">在学</div>
                </a>
            </div>

            <div class="user-menus">
                <div class="body">
                    <a href="{{route('role.index')}}" class="menu-item">
                        <div class="icon" style="color: #AA7500">
                            <i class="iconfont iconVIP"></i>
                        </div>
                        <div class="text">会员中心</div>
                    </a>
                    <a href="{{route('member.profile')}}" class="menu-item">
                        <div class="icon" style="color: #FA8C16">
                            <i class="iconfont iconperson"></i>
                        </div>
                        <div class="text">我的资料</div>
                    </a>
                    <a href="{{route('member.credit1_records')}}" class="menu-item">
                        <div class="icon" style="color: #FF4D4F">
                            <i class="iconfont iconcoin"></i>
                        </div>
                        <div class="text">我的积分</div>
                    </a>
                    <a href="{{route('member.promo_code')}}" class="menu-item">
                        <div class="icon" style="color: #9366F2">
                            <i class="iconfont iconinvite"></i>
                        </div>
                        <div class="text">我的邀请</div>
                    </a>
                </div>
            </div>
        </div>

        @include('h5.components.tabbar', ['active' => 'user'])

    @endif
@endsection