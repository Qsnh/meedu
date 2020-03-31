@extends('layouts.app-active')

@section('content')

    <div class="course-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="nav-bar">
                        <a href="{{route('courses')}}">所有课程</a>
                        <span>></span>
                        <a href="{{route('course.show', [$course['id'], $course['slug']])}}">{{$course['title']}}</a>
                        <span>></span>
                        <a href="javascript:void(0)">{{$video['title']}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="video-player">
                    @if($user)
                        @if($canSeeVideo)
                            <div class="box-shadow1">
                                @if($video['aliyun_video_id'])
                                    @include('frontend.components.player.aliyun', ['video' => $video])
                                @elseif($video['tencent_video_id'])
                                    @include('frontend.components.player.tencent', ['video' => $video])
                                @else
                                    @include('frontend.components.player.aliyunSimple', ['video' => $video])
                                @endif
                            </div>
                        @else
                            <div class="buy-this-video">
                                <h3>{{$video['title']}}</h3>
                                <a href="javascript:void(0)"
                                   class="btn btn-primary mt-3 show-select-payment-model">付费内容，请订阅后查看</a>
                            </div>
                        @endif
                    @else
                        <div class="need-login">
                            <h3>{{$video['title']}}</h3>
                            <p class="mt-5"><a data-login="0" class="btn btn-primary login-auth"
                                               href="{{route('login')}}">登录</a></p>
                            <p class="login-text">
                                登录后才可以观看视频哦 ^ - ^！
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="course-menu-box mt-0" style="border-top-left-radius: 0px; border-top-right-radius: 0px;">
                    <div class="menu-item {{!$scene ? 'active' : ''}}">
                        <a href="{{route('video.show', [$course['id'], $video['id'], $video['slug']])}}"
                           data-page="video-show-page-desc" class="video-show-page-item">视频介绍</a>
                    </div>
                    <div class="menu-item {{$scene === 'chapter' ? 'active' : ''}}">
                        <a href="{{route('video.show', [$course['id'], $video['id'], $video['slug']])}}?scene=chapter"
                           data-page="video-show-page-chapter" class="video-show-page-item">课程目录</a>
                    </div>
                    <div class="menu-item {{$scene === 'comment' ? 'active' : ''}}">
                        <a href="{{route('video.show', [$course['id'], $video['id'], $video['slug']])}}?scene=comment"
                           data-page="video-show-page-comment" class="video-show-page-item">讨论区</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container {{!$scene ? '' : 'display-none'}} video-show-page-desc">
            <div class="row">
                <div class="col-12">
                    {!! $video['render_desc'] !!}
                </div>
            </div>
        </div>
        <div class="container {{$scene === 'chapter' ? '' : 'display-none'}} video-show-page-chapter">
            <div class="row">
                <div class="col-12">
                    <div class="course-chapter">
                        @if($chapters)
                            @foreach($chapters as $chapter)
                                <div class="course-chapter-title">{{$chapter['title']}}</div>
                                @foreach($videos[$chapter['id']] ?? [] as $videoItem)
                                    <div class="course-videos-box">
                                        <div class="course-videos-item {{$videoItem['id'] === $video['id'] ? 'active' : ''}} {{$loop->first ? 'first' : ''}} {{$loop->last ? 'last' : ''}}">
                                            <span class="player-icon"></span>
                                            <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                               class="video-title">{{$videoItem['title']}}</a>
                                            @if($videoItem['charge'] === 0)
                                                <span class="free-label">免费</span>
                                            @endif
                                            <span class="video-duration">{{duration_humans($videoItem['duration'])}}</span>
                                            <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                               class="learn-button">开始学习</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @else
                            @foreach($videos[0] ?? [] as $videoItem)
                                <div class="course-videos-box">
                                    <div class="course-videos-item {{$videoItem['id'] === $video['id'] ? 'active' : ''}} {{$loop->first ? 'first' : ''}} {{$loop->last ? 'last' : ''}}">
                                        <span class="player-icon"></span>
                                        <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                           class="video-title">{{$videoItem['title']}}</a>
                                        @if($videoItem['charge'] === 0)
                                            <span class="free-label">免费</span>
                                        @endif
                                        <span class="video-duration">{{duration_humans($video['duration'])}}</span>
                                        <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                           class="learn-button">开始学习</a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="container {{$scene === 'comment' ? '' : 'display-none'}} video-show-page-comment">
            <div class="row">
                <div class="col-12">
                    <div class="comment-box">
                        <div class="comment-title">
                            本课讨论
                        </div>
                        <div class="comment-input-box">
                            <textarea name="content" placeholder="请输入评论内容" class="form-control" rows="3"></textarea>
                            <button type="button" data-url="{{route('ajax.video.comment', [$video['id']])}}"
                                    data-login="{{$user ? 1 : 0}}" data-input="content" class="comment-button">评论
                            </button>
                        </div>
                    </div>

                    <div class="comment-list-box">
                        @forelse($comments as $commentItem)
                            <div class="comment-list-item">
                                <div class="comment-user-avatar">
                                    <img src="{{$commentUsers[$commentItem['user_id']]['avatar']}}" width="70"
                                         height="70">
                                </div>
                                <div class="comment-content-box">
                                    <div class="comment-user-nickname">{{$commentUsers[$commentItem['user_id']]['nick_name']}}</div>
                                    <div class="comment-content">
                                        {!! $commentItem['render_content'] !!}
                                    </div>
                                    <div class="comment-info">
                                        <span class="comment-createAt">{{\Carbon\Carbon::parse($commentItem['created_at'])->diffForHumans()}}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            @include('frontend.components.none')
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

    <div class="select-payment-model">
        <div class="select-payment-model-box">
            <div class="title">付费内容 <img src="{{asset('/images/close.png')}}" class="close-select-payment-model"
                                         width="24" height="24"></div>
            <div class="content">
                <div class="role-text">
                    <img src="{{asset('/images/icons/vip.png')}}" width="24" height="24">
                    <span>开通会员，全站资源随意看</span>
                </div>
                <div class="join-role-button-box">
                    <a href="{{route('role.index')}}" class="join-role-button">开通会员</a>
                </div>
                <div class="extra-options">
                    <a href="{{route('member.course.buy', [$course['id']])}}" class="plain-text">
                        订阅此套课程￥{{$course['charge']}}
                        <img src="{{asset('/images/icons/right.png')}}" width="6" height="10">
                    </a>
                </div>
                <div class="extra-options">
                    <a href="{{ route('member.video.buy', [$video['id']]) }}" class="plain-text">
                        仅订阅该视频￥{{$video['charge']}}
                        <img src="{{asset('/images/icons/right.png')}}" width="6" height="10">
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection