@extends('layouts.app')

@section('content')

    <div class="container member">
        <div class="row">
            <div class="col-sm-3 member-left-box">
                <div class="row">
                    <div class="col-sm-12 avatar border">
                        <p>
                            <a href="{{ route('member.avatar') }}">
                                <img src="{{ $user->avatar }}" width="80" height="80">
                            </a>
                        </p>
                        <p class="nickname">{{ $user->nick_name }}</p>
                        <p class="lh-30">注册于 &nbsp; <span class="color-gray">{{ $user->created_at->diffForHumans() }}</span></p>
                        @if($user->role)
                            <p class="lh-30">
                                <span class="badge badge-primary">{{$user->role->name}} {{$user->role_expired_at}}</span>
                            </p>
                        @endif
                        <p class="lh-30">余额
                            <b>￥{{ $user->credit1 }}</b>
                        </p>
                    </div>

                    <div class="col-sm-12 member-left-menu border">
                        <ul>
                            <li>
                                <a href="{{ route('member') }}">
                                    <i class="fa fa-dashboard"></i> 会员中心
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.orders') }}">
                                    <i class="fa fa-envelope-open-o"></i> 我的订单
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.books') }}">
                                    <i class="fa fa-book"></i> 我的电子书
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.courses') }}">
                                    <i class="fa fa-file"></i> 已购课程
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.course.videos') }}">
                                    <i class="fa fa-film"></i> 已购视频
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.join_role_records') }}">
                                    <i class="fa fa-users"></i> 会员记录
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('member.password_reset') }}">
                                    <i class="fa fa-cogs"></i> 修改密码
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> 安全退出
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-sm-9 member-box border">
                <div class="col-sm-12">
                    @yield('member')
                </div>
            </div>
        </div>
    </div>

@endsection