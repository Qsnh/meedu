@extends('h5.app')

@section('content')

    <div class="weui-flex bg-fff pv-10">
        <div class="member-avatar-box">
            <img src="{{$user['avatar']}}" class="member-avatar-img" width="70" height="70"
                 alt="{{$user['nick_name']}}">
        </div>
        <div class="weui-flex__item">
            <div class="member-info-right-box">
                <h3>{{$user['nick_name']}}</h3>
                <p>
                    @if($user['role'] ?? [])
                        <span>{{$user['role']['name']}}</span>
                    @else
                        <span>免费会员</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="weui-panel">
        <div class="weui-panel__bd">
            <div class="weui-media-box weui-media-box_small-appmsg">
                <div class="weui-cells">
                    <a class="weui-cell weui-cell_access weui-cell_example" href="{{route('member.messages')}}">
                        <div class="weui-cell__hd">
                            <img src="{{asset('/h5/images/message.png')}}"
                                 style="width:20px;margin-right:16px;display:block">
                        </div>
                        <div class="weui-cell__bd weui-cell_primary">
                            <p>我的消息</p>
                        </div>
                        <span class="weui-cell__ft"></span>
                    </a>
                    <a class="weui-cell weui-cell_access weui-cell_example" href="{{route('member.courses')}}">
                        <div class="weui-cell__hd">
                            <img src="{{asset('/h5/images/course.png')}}"
                                 style="width:20px;margin-right:16px;display:block">
                        </div>
                        <div class="weui-cell__bd weui-cell_primary">
                            <p>我的课程</p>
                        </div>
                        <span class="weui-cell__ft"></span>
                    </a>
                    <a class="weui-cell weui-cell_access weui-cell_example" href="{{route('member.course.videos')}}">
                        <div class="weui-cell__hd">
                            <img src="{{asset('/h5/images/video.png')}}"
                                 style="width:20px;margin-right:16px;display:block">
                        </div>
                        <div class="weui-cell__bd weui-cell_primary">
                            <p>我的视频</p>
                        </div>
                        <span class="weui-cell__ft"></span>
                    </a>
                    <a class="weui-cell weui-cell_access weui-cell_example" href="{{route('member.orders')}}">
                        <div class="weui-cell__hd">
                            <img src="{{asset('/h5/images/order.png')}}"
                                 style="width:20px;margin-right:16px;display:block">
                        </div>
                        <div class="weui-cell__bd weui-cell_primary">
                            <p>我的订单</p>
                        </div>
                        <span class="weui-cell__ft"></span>
                    </a>
                    <a class="weui-cell weui-cell_access weui-cell_example"
                       href="{{route('member.join_role_records')}}">
                        <div class="weui-cell__hd">
                            <img src="{{asset('/h5/images/vip.png')}}"
                                 style="width:20px;margin-right:16px;display:block">
                        </div>
                        <div class="weui-cell__bd weui-cell_primary">
                            <p>会员记录</p>
                        </div>
                        <span class="weui-cell__ft"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection