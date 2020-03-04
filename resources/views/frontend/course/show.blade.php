@extends('layouts.app-active')

@section('content')

    <div class="course-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="nav-bar">
                        <a href="{{route('courses')}}">所有课程</a>
                        <span>></span>
                        <a href="{{route('courses')}}?category_id={{$category['id']}}">{{$category['name']}}</a>
                        <span>></span>
                        <a href="javascript:void(0)">{{$course['title']}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="course-info-box">
                    <div class="course-thumb">
                        <img class="course-thumb-img" src="{{$course['thumb']}}" width="320" height="240">
                        @if($isBuy)
                            <div class="paid">
                                <img src="/images/icons/paid.png" width="100" height="100">
                            </div>
                        @endif
                    </div>
                    <div class="course-info">
                        <h2 class="course-title">
                            {{$course['title']}}

                            @if($isLikeCourse)
                                <div data-login="{{$user ? 1 : 0}}"
                                     data-url="{{route('ajax.course.like', [$course['id']])}}" class="like-button">
                                    <img src="/images/icons/like-hover.png" width="24" height="24">
                                    <span>已收藏</span>
                                </div>
                            @else
                                <div data-login="{{$user ? 1 : 0}}"
                                     data-url="{{route('ajax.course.like', [$course['id']])}}" class="like-button">
                                    <img src="/images/icons/like.png" width="24" height="24">
                                    <span>收藏课程</span>
                                </div>
                            @endif
                        </h2>
                        <div class="course-description">{{$course['short_description']}}</div>
                        <div class="course-extra-info">
                            @if($isBuy)
                                @if($firstVideo)
                                    <a href="{{route('video.show', [$firstVideo['course_id'], $firstVideo['id'], $firstVideo['slug']])}}"
                                       class="buy-course-button">开始学习</a>
                                @else
                                    <a href="javascript:void(0);" onclick="flashWarning('暂无视频')"
                                       class="buy-course-button">开始学习</a>
                                @endif
                            @else
                                <span class="course-price"><small>￥</small>{{$course['charge']}}</span>
                                <a href="{{route('member.course.buy', [$course['id']])}}"
                                   class="buy-course-button">订阅课程</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="course-menu-box"
                     style="margin-top: 0px; border-radius:0px 0px 8px 8px; box-shadow:0px 4px 8px 0px rgba(229,229,229,1); padding-left: 30px;">
                    <div class="menu-item active">
                        <a href="javascript:void(0)">课程目录</a>
                    </div>
                    <div class="menu-item">
                        <a href="javascript:void(0)">讨论区</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="course-chapter">
                    @if($chapters)
                        @foreach($chapters as $chapter)
                            <div class="course-chapter-title">{{$chapter['title']}}</div>
                            @foreach($videos[$chapter['id']] ?? [] as $video)
                                <div class="course-videos-box">
                                    <div class="course-videos-item {{$loop->first ? 'first' : ''}} {{$loop->last ? 'last' : ''}}">
                                        <span class="player-icon"></span>
                                        <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                                           class="video-title">{{$video['title']}}</a>
                                        @if($video['charge'] === 0)
                                            <span class="free-label">免费</span>
                                        @endif
                                        <span class="video-duration">{{duration_humans($video['duration'])}}</span>
                                        @if($isBuy)
                                            <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                                               class="learn-button">继续学习</a>
                                        @elseif($video['charge'] === 0)
                                            <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                                               class="learn-button">免费学习</a>
                                        @else
                                            <span class="buy-course-button">单独订阅</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        @foreach($videos[0] ?? [] as $video)
                            <div class="course-videos-box">
                                <div class="course-videos-item {{$loop->first ? 'first' : ''}} {{$loop->last ? 'last' : ''}}">
                                    <span class="player-icon"></span>
                                    <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                                       class="video-title">{{$video['title']}}</a>
                                    @if($video['charge'] === 0)
                                        <span class="free-label">免费</span>
                                    @endif
                                    <span class="video-duration">{{duration_humans($video['duration'])}}</span>
                                    @if($isBuy)
                                        <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                                           class="learn-button">继续学习</a>
                                    @elseif($video['charge'] === 0)
                                        <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                                           class="learn-button">免费学习</a>
                                    @else
                                        <span class="buy-course-button">单独订阅</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection