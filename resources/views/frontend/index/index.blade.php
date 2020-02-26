@extends('layouts.app')

@section('css')
    <link crossorigin="anonymous" integrity="sha384-K6LrEaceM4QP87RzJ7R4CDXcFN4cFW/A5Q7/fEp/92c2WV+woVw9S9zKDO23sNS+"
          href="https://lib.baomitu.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container slider-box">
        <div class="row">
            <div class="col-12">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($sliders as $slider)
                            <a class="swiper-slide" href="{{$slider['url']}}">
                                <img src="{{$slider['thumb']}}" width="100%" height="400">
                            </a>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="course-menu-box">
                    <div class="menu-item active">
                        <a href="{{route('courses')}}">所有课程</a>
                    </div>
                    <div class="menu-item">
                        <a href="{{route('courses')}}?scene=latest">最新课程</a>
                    </div>
                    <div class="menu-item">
                        <a href="{{route('courses')}}?scene=sub">订阅最多</a>
                    </div>

                    @if($gAnnouncement)
                        <div class="menu-announcement">
                            <a href="{{route('announcement.show', [$gAnnouncement['id']])}}">{{$gAnnouncement['title']}}</a>
                        </div>
                    @endif
                </div>

                <div class="category-box">
                    <a href="{{route('courses')}}" class="category-box-item active">不限</a>
                    @foreach($categories as $category)
                        <a href="{{route('courses')}}?category_id={{$category['id']}}"
                           class="category-box-item">{{$category['name']}}</a>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                <div class="course-list-box">
                    @foreach($courses as $index => $course)
                        <a href="{{route('course.show', [$course['id'], $course['slug']])}}"
                           class="course-list-item {{(($index + 1) % 4 == 0) ? 'last' : ''}}">
                            <div class="course-thumb">
                                <img src="{{$course['thumb']}}" width="280" height="210" alt="{{$course['title']}}">
                            </div>
                            <div class="course-title">
                                {{$course['title']}}
                            </div>
                            <div class="course-category">
                                <span class="video-count-label">课时：{{$course['videos_count']}}节</span>
                                <span class="category-label">{{$course['category']['name']}}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-12">
                {!! str_replace('pagination', 'pagination justify-content-center', $courses->render()) !!}
            </div>
        </div>
    </div>

    <div class="container-fluid friend-link-box">
        <div class="container">
            <div class="row">
                <div class="col-12 friend-link-box-logo">
                    <img src="{{$gConfig['system']['logo']}}" height="37" alt="{{config('app.name')}}">
                </div>
                <div class="col-12 friend-link-box-link">
                    @foreach($links as $link)
                        <a href="{{$link['url']}}" target="_blank">{{$link['name']}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script crossorigin="anonymous" integrity="sha384-fOtis9P3S4B2asdoye1/YBpXMaRmuXu925gZhfQA/gnU3dLnftD8zvpk/lhP0YSG"
            src="https://lib.baomitu.com/Swiper/4.5.0/js/swiper.min.js"></script>
    <script>
        var mySwiper = new Swiper('.swiper-container', {
            autoplay: true,
            effect: 'fade',
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
@endsection