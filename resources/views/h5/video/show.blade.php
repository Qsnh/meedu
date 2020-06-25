@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '课程详情', 'back' => route('course.show', [$course['id'], $course['slug']]), 'class' => 'dark'])

    <div class="video-play-box">
        @if($user)
            @if($canSeeVideo)
                @if($video['aliyun_video_id'] && (int)($gConfig['system']['player']['enabled_aliyun_private'] ?? 0) === 1)
                    @include('h5.components.player.aliyun', ['video' => $video])
                @else
                    @include('h5.components.player.xg', ['video' => $video])
                @endif
                @if($nextVideo)
                    <div style="margin-top: 60px;display: none" class="text-center watched-over">
                        <a class="btn btn-primary"
                           href="{{route('video.show', [$nextVideo['course_id'], $nextVideo['id'], $nextVideo['slug']])}}">下一集</a>
                    </div>
                @else
                    <div style="margin-top: 60px;display: none;" class="text-center watched-over">
                        <span style="color: white">厉害，当前课程已全部看完！</span>
                    </div>
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
        <div class="menu-item" data-dom="course-description">介绍</div>
        <div class="menu-item active" data-dom="course-chapter">目录</div>
        <div class="menu-item" data-dom="course-comment">评论</div>
    </div>

    <div class="course-description course-content-tab-item" style="display: none">
        {!! $video['render_desc'] !!}
    </div>

    <div class="course-chapter course-content-tab-item" style="display: block">
        @if($chapters)
            @foreach($chapters as $chapter)
                @if($videosBox = $videos[$chapter['id']] ?? [])@endif
                @if($videosBoxIds = array_column($videosBox, 'id'))@endif
                <div class="chapter-title">
                    {{$chapter['title']}}
                    <span class="videos-count" data-dom="chapter-videos-{{$chapter['id']}}">
                        {{count($videosBox)}}节
                        <i class="fa {{in_array($video['id'], $videosBoxIds) ? 'fa-angle-up' : 'fa-angle-down'}}"></i>
                    </span>
                </div>
                <div class="chapter-videos {{in_array($video['id'], $videosBoxIds) ? 'active' : ''}} chapter-videos-{{$chapter['id']}}">
                    @foreach($videosBox as $videoItem)
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

    <div class="course-comment course-content-tab-item">
        <div class="comment-input-box">
            <form action="">
                <div class="form-group">
                    <textarea name="comment-content" class="form-control" placeholder="{{$user ? '请输入评论的内容' : '请先登录'}}"
                              rows="1" {{$user ? '' : 'disabled'}}></textarea>
                </div>
                @if($user)
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-primary btn-sm comment-button"
                                data-login-url="{{route('login')}}"
                                data-url="{{route('ajax.video.comment', [$video['id']])}}"
                                data-login="{{$user ? 1 : 0}}" data-input="comment-content">评论
                        </button>
                    </div>
                @endif
            </form>
        </div>
        <div class="comment-list-box">
            @forelse($comments as $commentItem)
                <div class="comment-list-item">
                    <div class="comment-user-avatar">
                        <img src="{{$commentUsers[$commentItem['user_id']]['avatar']}}" width="44"
                             height="44">
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
                @include('h5.components.none')
            @endforelse
        </div>
    </div>

    @if($user && !$canSeeVideo && $video['charge'] > 0)
        <a href="javascript:void(0);" class="course-info-bottom-bar show-buy-course-model focus-c-white">订阅课程</a>
    @endif

    <div class="buy-course-model">
        <div class="buy-course-item-box">
            <div class="close">
                <img src="{{asset('/h5/images/icons/close.png')}}" width="18" height="18">
            </div>
            <div class="title">此套课程需付费，请选择</div>
            <a href="{{route('role.index')}}" class="active">成为会员所有视频免费看</a>
            @if($video['is_ban_sell'] !== \App\Constant\FrontendConstant::YES)
                <a href="{{route('member.video.buy', [$video['id']])}}">单独购买此条视频 ￥{{$video['charge']}}</a>
            @endif
            @if($course['charge'] > 0)
                <a href="{{route('member.course.buy', [$course['id']])}}">订阅此套课程 ￥{{$course['charge']}}</a>
            @endif
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(function () {
            $('.course-description').find('img').attr('width', 'auto').attr('height', 'auto');
        });
    </script>
@endsection