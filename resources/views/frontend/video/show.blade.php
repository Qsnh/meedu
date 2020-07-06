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
                                @if($video['aliyun_video_id'] && (int)($gConfig['system']['player']['enabled_aliyun_private'] ?? 0) === 1)
                                    @include('frontend.components.player.aliyun', ['video' => $video])
                                @else
                                    @if($video['player_pc'] === \App\Constant\FrontendConstant::PLAYER_ALIYUN)
                                        @include('frontend.components.player.aliyun', ['video' => $video])
                                    @elseif($video['player_pc'] === \App\Constant\FrontendConstant::PLAYER_TENCENT)
                                        @include('frontend.components.player.tencent', ['video' => $video])
                                    @else
                                        @include('frontend.components.player.xg', ['video' => $video])
                                    @endif
                                @endif
                            </div>
                            @if($nextVideo)
                                <div class="need-login" style="display: none">
                                    <p class="mt-5">
                                        <a class="btn btn-primary"
                                           href="{{route('video.show', [$nextVideo['course_id'], $nextVideo['id'], $nextVideo['slug']])}}">下一集</a>
                                    </p>
                                    <p class="login-text">
                                        下一集：{{$nextVideo['title']}}
                                    </p>
                                </div>
                            @else
                                <div class="need-login" style="display: none">
                                    <h3>厉害，课程已全部看完！</h3>
                                </div>
                            @endif
                        @else
                            @if($trySee)
                                <div class="box-shadow1">
                                    @if($video['aliyun_video_id'] && (int)($gConfig['system']['player']['enabled_aliyun_private'] ?? 0) === 1)
                                        @include('frontend.components.player.aliyun', ['video' => $video, 'isTry' => true])
                                    @else
                                        @if($video['player_pc'] === \App\Constant\FrontendConstant::PLAYER_ALIYUN)
                                            @include('frontend.components.player.aliyun', ['video' => $video, 'isTry' => true])
                                        @elseif($video['player_pc'] === \App\Constant\FrontendConstant::PLAYER_TENCENT)
                                            @include('frontend.components.player.tencent', ['video' => $video, 'isTry' => true])
                                        @else
                                            @include('frontend.components.player.xg', ['video' => $video, 'isTry' => true])
                                        @endif
                                    @endif
                                </div>
                                <div class="need-login" style="display: none">
                                    <h3>您观看的是试看内容，如需观看完整内容请先订阅！</h3>
                                </div>
                            @else
                                <div class="buy-this-video">
                                    <h3>{{$video['title']}}</h3>
                                    <a href="javascript:void(0)"
                                       class="btn btn-primary mt-3 show-select-payment-model">付费内容，请订阅后查看</a>
                                </div>
                            @endif
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
                            @foreach($chapters as $chapterIndex => $chapter)
                                @if($videosBox = $videos[$chapter['id']] ?? [])@endif
                                @if($videosBoxIds = array_column($videosBox, 'id'))@endif
                                <div class="course-chapter-title">
                                    {{$chapter['title']}}
                                    <small class="videos-count"
                                           data-dom="course-videos-box-{{$chapter['id']}}">{{count($videosBox)}}节 <i
                                                class="fa {{in_array($video['id'], $videosBoxIds) ? 'fa-angle-up' : 'fa-angle-down'}}"></i></small>
                                </div>
                                @foreach($videosBox as $videoItem)
                                    <div class="course-videos-box {{in_array($video['id'], $videosBoxIds) ? 'active' : ''}} course-videos-box-{{$chapter['id']}}">
                                        <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                           class="course-videos-item {{$videoItem['id'] === $video['id'] ? 'active' : ''}} {{$loop->first ? 'first' : ''}} {{$loop->last ? 'last' : ''}}">
                                            <div class="player-icon"></div>
                                            <div class="video-title">
                                                {{$videoItem['title']}}
                                                @if($videoItem['charge'] === 0)
                                                    <span class="free-label">免费</span>
                                                @else
                                                    @if($videoItem['free_seconds'] > 0)
                                                        <span class="free-label">试看</span>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="video-duration">
                                                @if(isset($videoWatchedProgress[$videoItem['id']]) && $videoWatchedProgress[$videoItem['id']]['watched_at'])
                                                    已看完
                                                @else
                                                    {{duration_humans($videoItem['duration'])}}
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endforeach
                        @else
                            @foreach($videos[0] ?? [] as $videoItem)
                                <div class="course-videos-box" style="display: block">
                                    <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                       class="course-videos-item {{$videoItem['id'] === $video['id'] ? 'active' : ''}} {{$loop->first ? 'first' : ''}} {{$loop->last ? 'last' : ''}}">
                                        <div class="player-icon"></div>
                                        <div class="video-title">
                                            {{$videoItem['title']}}
                                            @if($videoItem['charge'] === 0)
                                                <span class="free-label">免费</span>
                                            @else
                                                @if($videoItem['free_seconds'] > 0)
                                                    <span class="free-label">试看</span>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="video-duration">
                                            @if(isset($videoWatchedProgress[$videoItem['id']]) && $videoWatchedProgress[$videoItem['id']]['watched_at'])
                                                已看完
                                            @else
                                                {{duration_humans($videoItem['duration'])}}
                                            @endif
                                        </div>
                                    </a>
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
                    @if($canComment)
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
                    @endif

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
                @if($video['is_ban_sell'] !== \App\Constant\FrontendConstant::YES)
                    <div class="extra-options">
                        <a href="{{ route('member.video.buy', [$video['id']]) }}" class="plain-text">
                            仅订阅该视频￥{{$video['charge']}}
                            <img src="{{asset('/images/icons/right.png')}}" width="6" height="10">
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection