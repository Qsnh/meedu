@extends('h5.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.staticfile.org/Swiper/4.5.1/css/swiper.min.css">
@endsection

@section('content')

    <div class="weui-flex">
        <div class="weui-flex__item swiper-box">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($gLatestCourses as $course)
                        <div class="swiper-slide">
                            <a href="{{ route('course.show', [$course['id'], $course['slug']]) }}">
                                <img src="{{ image_url($course['thumb']) }}" width="100%" height="180"
                                     alt="{{$course['title']}}">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>

    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">最新课程</div>
        <div class="weui-panel__bd">
            @foreach($gLatestCourses as $index => $course)
                @if($index > 2)
                    @break;
                @endif
                <a href="{{ route('course.show', [$course['id'], $course['slug']]) }}"
                   class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd">
                        <img src="{{ image_url($course['thumb']) }}" class="weui-media-box__thumb">
                    </div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">{{$course['title']}}</h4>
                        <p class="weui-media-box__desc">{{$course['short_description']}}</p>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="weui-panel__ft">
            <a href="{{route('courses')}}" class="weui-cell weui-cell_access weui-cell_link">
                <div class="weui-cell__bd">查看更多</div>
                <span class="weui-cell__ft"></span>
            </a>
        </div>
    </div>

    <div class="weui-panel">
        <div class="weui-panel__hd">最新视频</div>
        <div class="weui-panel__bd">
            @foreach($gLatestVideos as $index => $video)
                @if($index > 4)
                    @break;
                @endif
                <div class="weui-media-box weui-media-box_text">
                    <h4 class="weui-media-box__title">{{$video['title']}}</h4>
                    <p class="weui-media-box__desc">{{$video['short_description']}}</p>
                    <ul class="weui-media-box__info">
                        <li class="weui-media-box__info__meta">{{$video['course']['title']}}</li>
                        <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">￥{{$video['charge']}}</li>
                    </ul>
                </div>
            @endforeach
        </div>
        <div class="weui-panel__ft">
            <a href="{{route('videos')}}" class="weui-cell weui-cell_access weui-cell_link">
                <div class="weui-cell__bd">查看更多</div>
                <span class="weui-cell__ft"></span>
            </a>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.staticfile.org/Swiper/4.5.1/js/swiper.min.js"></script>
    <script>
        $(function () {
            new Swiper('.swiper-container', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                }
            });
        });
    </script>
@endsection