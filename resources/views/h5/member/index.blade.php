@extends('layouts.h5-pure')

@section('css')
    <style>
        body {
            background-color: #F2F6F9;
        }
    </style>
@endsection

@section('content')

    <div class="user-detail-page">
        <div class="user-info-box">
            <div class="avatar">
                <img src="{{$user['avatar']}}" width="66" height="66">
            </div>
            <div class="info">
                <div class="nickname">
                    {{$user['nick_name']}}
                </div>
                <div class="stat">
                    <span>积分 <b>{{$user['credit1']}}</b></span>
                </div>
            </div>
        </div>

        <div class="user-main-menus">
            <a class="item" href="{{route('member.orders')}}">
                <div class="icon" style="color: #e4716d"><i class="iconfont iconorder"></i></div>
                <div class="text">订单</div>
            </a>
            <a class="item" href="{{route('member.messages')}}">
                <div class="icon" style="color: #8dd6a3"><i class="iconfont iconnews"></i></div>
                <div class="text">消息</div>
            </a>
            <a class="item" href="{{route('member.courses')}}?scene=like">
                <div class="icon" style="color: #f4c348"><i class="iconfont iconcollect"></i></div>
                <div class="text">收藏</div>
            </a>
            <a class="item" href="{{route('member.courses')}}">
                <div class="icon" style="color: #63aef4"><i class="iconfont icondoc"></i></div>
                <div class="text">在学</div>
            </a>
        </div>

        <div class="user-menus">
            <div class="body">
                <a href="{{route('role.index')}}" class="menu-item">
                    <div class="icon" style="color: #a07726">
                        <i class="iconfont iconVIP"></i>
                    </div>
                    <div class="text">会员中心</div>
                </a>
                <a href="{{route('member.credit1_records')}}" class="menu-item">
                    <div class="icon" style="color: #e85b56">
                        <i class="iconfont iconcoin"></i>
                    </div>
                    <div class="text">我的积分</div>
                </a>
                <a href="{{route('member.promo_code')}}" class="menu-item">
                    <div class="icon" style="color: #86baea">
                        <i class="iconfont iconinvite"></i>
                    </div>
                    <div class="text">我的邀请</div>
                </a>
            </div>
        </div>

        <div class="logout-button-box">
            <a href="javascript:void(0)" class="logout-button"
               onclick="document.getElementById('logout-form').submit();">安全退出</a>
            <form id="logout-form" action="{{ route('logout') }}"
                  method="POST">
                @csrf
            </form>
        </div>
    </div>

    @include('h5.components.tabbar', ['active' => 'user'])

@endsection