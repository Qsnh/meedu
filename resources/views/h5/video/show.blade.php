@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '课程详情', 'back' => route('course.show', [$course['id'], $course['slug']]), 'class' => 'dark'])

    <div class="video-play-box">
        @if($user)
            @if($canSeeVideo)
                @if($video['aliyun_video_id'])
                    @include('h5.components.player.aliyun', ['video' => $video])
                @elseif($video['tencent_video_id'])
                    @include('h5.components.player.tencent', ['video' => $video])
                @else
                    @include('h5.components.player.aliyunSimple', ['video' => $video])
                @endif
            @else
                <div style="padding-top: 60px;" class="text-center">
                    <a href="javascript:void(0)" class="btn btn-primary btn-sm show-buy-course-model">请先购买</a>
                </div>
            @endif
        @else
            <div style="margin-top: 60px;" class="text-center">
                <a class="btn btn-primary" href="{{route('login')}}">登录</a>
            </div>
        @endif
    </div>

    <div class="course-info-menu">
        <div class="menu-item active"
             onclick="$(this).addClass('active').siblings().removeClass('active');$('.course-chapter').hide();$('.course-description').show();">
            <a href="javascript:void(0)">视频介绍</a>
        </div>
        <div class="menu-item"
             onclick="$(this).addClass('active').siblings().removeClass('active');$('.course-description').hide();$('.course-chapter').show();">
            <a href="javascript:void(0)">课程目录</a>
        </div>
        @if($user)
            @if(app()->make(\App\Businesses\BusinessState::class)->isRole($user))
                <div class="label">{{$user['role']['name']}}</div>
            @elseif($canSeeVideo && $video['charge'] > 0)
                <div class="label">已订阅</div>
            @endif
        @endif
    </div>

    <div class="course-description">{!! $video['render_desc'] !!}</div>

    <div class="course-chapter">
        @if($chapters)
            @foreach($chapters as $chapter)
                <div class="chapter-title">{{$chapter['title']}}</div>
                <div class="chapter-videos">
                    @foreach($videos[$chapter['id']] ?? [] as $videoItem)
                        <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                           class="chapter-video-item {{$videoItem['id'] === $video['id'] ? 'active' : ''}}">
                            <span class="video-title">{{$videoItem['title']}}</span>
                            @if($videoItem['charge'] === 0)
                                <span class="video-label">免费</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="chapter-videos">
                @foreach($videos[0] ?? [] as $videoItem)
                    <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                       class="chapter-video-item {{$videoItem['id'] === $video['id'] ? 'active' : ''}}">
                        <span class="video-title">{{$videoItem['title']}}</span>
                        @if($videoItem['charge'] === 0)
                            <span class="video-label">免费</span>
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    @if(!$canSeeVideo)
        <a href="javascript:void(0);" class="course-info-bottom-bar show-buy-course-model focus-c-white">订阅课程</a>
    @endif

    <div class="buy-course-model">
        <div class="buy-course-item-box">
            <div class="close">
                <img src="{{asset('/h5/images/icons/close.png')}}" width="18" height="18">
            </div>
            <div class="title">此套课程需付费，请选择</div>
            <a href="{{route('role.index')}}" class="active">成为会员所有视频免费看</a>
            <a href="{{route('member.video.buy', [$video['id']])}}">单独购买此条视频 ￥{{$video['charge']}}</a>
            <a href="{{route('member.course.buy', [$course['id']])}}">订阅此套课程 ￥{{$course['charge']}}</a>
        </div>
    </div>

@endsection