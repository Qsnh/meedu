@extends('layouts.h5-pure')

@section('css')
    <style>
        body {
            background-color: white;
        }
    </style>
@endsection

@section('content')

    <div class="course-info-box">
        <div class="course-thumb">
            <div class="title">
                <a href="javascript:void(0)" data-url="{{route('courses')}}" class="back back-button">
                    <img src="{{asset('/h5/images/icons/back-white.png')}}" width="24" height="24">
                </a>
                <div class="text">
                    {{$course['title']}}
                </div>
            </div>
            <img src="{{$course['thumb']}}" width="100%">
        </div>
    </div>

    <div class="course-info-menu">
        <div class="menu-item active" data-dom="course-description">
            介绍
            <span class="active-bar"></span>
        </div>
        <div class="menu-item" data-dom="course-chapter">
            目录
            <span class="active-bar"></span>
        </div>
        <div class="menu-item" data-dom="course-comment">
            评论
            <span class="active-bar"></span>
        </div>
        <div class="menu-item" data-dom="course-attach">
            附件
            <span class="active-bar"></span>
        </div>
    </div>

    <div class="course-description course-content-tab-item">
        {!! $course['render_desc'] !!}
    </div>

    <div class="course-chapter course-content-tab-item">
        @if($chapters)
            @foreach($chapters as $chapterIndex => $chapter)
                @if($videosBox = $videos[$chapter['id']] ?? [])@endif
                <div class="chapter-title show-chapter-videos-box" data-dom="chapter-videos-{{$chapter['id']}}">
                    {{$chapter['title']}}
                    <span class="videos-count">
                        <i class="fa {{$chapterIndex === 0 ? 'fa-angle-up' : 'fa-angle-down'}} fa-lg"></i>
                    </span>
                </div>
                <div class="chapter-videos {{$chapterIndex === 0 ? 'active' : ''}} chapter-videos-{{$chapter['id']}}">
                    @foreach($videosBox as $video)
                        <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                           class="chapter-video-item">
                            <span class="video-title">{{$video['title']}}</span>
                            @if($video['charge'] === 0)
                                <span class="video-label">免费</span>
                            @else
                                @if($video['free_seconds'] > 0)
                                    <span class="video-label">试看</span>
                                @endif
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="chapter-videos" style="display: block">
                @foreach($videos[0] ?? [] as $video)
                    <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                       class="chapter-video-item">
                        <span class="video-title">{{$video['title']}}</span>
                        @if($video['charge'] === 0)
                            <span class="video-label">免费</span>
                        @else
                            @if($video['free_seconds'] > 0)
                                <span class="video-label">试看</span>
                            @endif
                        @endif
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <div class="course-comment course-content-tab-item">
        <div class="comment-list-box">
            @forelse($comments as $commentItem)
                <div class="comment-list-item">
                    <div class="comment-user-avatar">
                        <img src="{{$commentUsers[$commentItem['user_id']]['avatar']}}" width="32"
                             height="32">
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
        @if($canComment)
            <div class="video-course-comment-icon show-course-comment-box"
                 data-login="{{$user ? 1 : 0}}"
                 data-login-url="{{route('login')}}">
                <i class="iconfont iconcomment"></i>
            </div>
        @endif
    </div>

    <div class="course-attach course-content-tab-item">
        @if(!$attach)
            @include('h5.components.none')
        @else
            @foreach($attach as $item)
                <a href="{{route('course.attach.download', $item['id'])}}?_t={{time()}}" class="course-attach-item">
                    <div class="file">
                        <div class="name">{{$item['name']}}</div>
                        <div class="size">{{round($item['size']/1024, 2)}}KB</div>
                    </div>
                    <div class="download-button">
                        <i class="iconfont icondownload"></i>
                    </div>
                </a>
            @endforeach
        @endif
    </div>

    <div class="course-comment-input-box-shadow">
        <div class="course-comment-input-box">
            <div class="title">
                <div class="text">课程评论</div>
            </div>
            <div class="content">
                <textarea name="content" rows="3" placeholder="请输入评论内容"></textarea>
            </div>
            <div class="buttons">
                <a href="javascript:void(0)" class="submit-comment-button comment-button" data-input="content"
                   data-login="{{$user ? 1 : 0}}"
                   data-login-url="{{route('login')}}"
                   data-url="{{route('ajax.course.comment', [$course['id']])}}">发布评论</a>
            </div>
            <div class="options">
                <a href="javascript:void(0)" class="cancel-course-comment close-course-comment-box">取消</a>
            </div>
        </div>
    </div>

    <div class="course-detail-bottom-bar">
        <div class="like-button {{$isLikeCourse ? 'active' : ''}}"
             data-login="{{$user ? 1 : 0}}"
             data-login-url="{{route('login')}}"
             data-url="{{route('ajax.course.like', [$course['id']])}}">
            <div class="icon">
                <i class="iconfont iconlike"></i>
            </div>
            <div class="text">收藏</div>
        </div>
        @if($isBuy)
            <a href="{{$firstVideo ? route('video.show', [$firstVideo['course_id'], $firstVideo['id'], $firstVideo['slug']]) : 'javascript:void(0)'}}"
               class="see-button-item button-item">开始学习</a>
        @else
            @if($course['charge'] > 0)
                <a href="{{route('member.course.buy', [$course['id']])}}" class="buy-course-button-item button-item">订购课程
                    ￥{{$course['charge']}}</a>
            @endif
            <a href="{{route('role.index')}}" class="buy-role-button-item button-item">会员免费看</a>
        @endif
    </div>
    <div class="course-detail-bottom-bar-block"></div>

@endsection

@section('js')
    <script>
        $(function () {
            $('.course-description').find('img').attr('width', 'auto').attr('height', 'auto');
        });
    </script>
@endsection