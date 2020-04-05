@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '课程详情', 'back' => route('index')])

    <div class="course-info-box">
        <div class="course-thumb">
            <img src="{{$course['thumb']}}" width="160" height="120">
        </div>
        <div class="course-info-desc">
            <div class="course-title">
                {{$course['title']}}
            </div>
            <div class="course-short-desc">{{$course['short_description']}}</div>
        </div>
    </div>

    <div class="course-info-menu">
        <div class="menu-item active"
             onclick="$(this).addClass('active').siblings().removeClass('active');$('.course-chapter').hide();$('.course-description').show();">
            <a href="javascript:void(0)">课程介绍</a>
        </div>
        <div class="menu-item"
             onclick="$(this).addClass('active').siblings().removeClass('active');$('.course-description').hide();$('.course-chapter').show();">
            <a href="javascript:void(0)">课程目录</a>
        </div>
    </div>

    <div class="course-description">{!! $course['render_desc'] !!}</div>

    <div class="course-chapter">
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