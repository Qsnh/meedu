@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '课程详情', 'back' => route('index')])

    <div class="course-info-box">
        <div class="course-thumb">
            <img src="{{$course['thumb']}}" width="100%" height="192">
            <div class="title">{{$course['title']}}</div>
        </div>
    </div>

    <div class="course-info-menu">
        <div class="menu-item active" data-dom="course-description">介绍</div>
        <div class="menu-item" data-dom="course-chapter">目录</div>
        <div class="menu-item" data-dom="course-comment">评论</div>
    </div>

    <div class="course-description course-content-tab-item">
        {!! $course['render_desc'] !!}
    </div>

    <div class="course-chapter course-content-tab-item">
        @if($chapters)
            @foreach($chapters as $chapter)
                <div class="chapter-title">{{$chapter['title']}}</div>
                <div class="chapter-videos">
                    @foreach($videos[$chapter['id']] ?? [] as $video)
                        <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                           class="chapter-video-item">
                            <span class="video-title">{{$video['title']}}</span>
                            @if($video['charge'] === 0)
                                <span class="video-label">免费</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="chapter-videos">
                @foreach($videos[0] ?? [] as $video)
                    <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                       class="chapter-video-item">
                        <span class="video-title">{{$video['title']}}</span>
                        @if($video['charge'] === 0)
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
                              rows="1"
                              {{$user ? '' : 'disabled'}}></textarea>
                </div>
                @if($user)
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-primary btn-sm comment-button"
                                data-login-url="{{route('login')}}"
                                data-url="{{route('ajax.course.comment', [$course['id']])}}"
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
                @include('frontend.components.none')
            @endforelse
        </div>
    </div>

    @if(!$isBuy && $course['charge'] > 0)
        <a href="javascript:void(0);" class="course-info-bottom-bar show-buy-course-model focus-c-white">订阅课程</a>
    @endif

    <div class="buy-course-model">
        <div class="buy-course-item-box">
            <div class="close">
                <img src="{{asset('/h5/images/icons/close.png')}}" width="18" height="18">
            </div>
            <div class="title">此套课程需付费，请选择</div>
            <a href="{{route('role.index')}}" class="active">成为会员所有视频免费看</a>
            <a href="{{route('member.course.buy', [$course['id']])}}">订阅此套课程 ￥{{$course['charge']}}</a>
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