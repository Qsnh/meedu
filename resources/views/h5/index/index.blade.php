@extends('layouts.h5')

@section('css')
    <link crossorigin="anonymous" integrity="sha384-K6LrEaceM4QP87RzJ7R4CDXcFN4cFW/A5Q7/fEp/92c2WV+woVw9S9zKDO23sNS+"
          href="https://lib.baomitu.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
    <style>
        .swiper-pagination {
            bottom: 0 !important;
        }
    </style>
@endsection

@section('content')

    <div class="swiper-box">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <a class="swiper-slide" href="{{$slider['url']}}">
                        <img src="{{$slider['thumb']}}" width="100%" height="115">
                    </a>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    @foreach($banners as $banner)
        <div class="index-banner-box">
            <div class="banner-title">{{$banner['name']}}</div>
            <div class="courses">
                @foreach($banner['courses'] as $index => $course)
                    <a href="{{route('course.show', [$course['id'], $course['slug']])}}"
                       class="banner-course-item {{$index % 2 === 0 ? 'first' : ''}}">
                        <div class="course-thumb" style="background-image: url('{{$course['thumb']}}')"></div>
                        <div class="course-title">{{$course['title']}}</div>
                        <div class="course-info">
                            <span class="course-category">{{$course['category']['name']}}</span>
                            <span class="course-video-count">{{$course['videos_count']}}课时</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="inspire">
        <p class="mb-0">“道可道也，非恒道也。名可名也，非恒名也。”</p>
    </div>

    <footer class="index-footer">
        <p>Powered By <a href="https://meedu.vip">MeEdu</a></p>
        <p>© {{date('Y')}} {{config('app.name')}} · <a href="http://www.beian.miit.gov.cn"
                                                       target="_blank">{{$gConfig['system']['icp']}}</a></p>
    </footer>

    <script crossorigin="anonymous" integrity="sha384-fOtis9P3S4B2asdoye1/YBpXMaRmuXu925gZhfQA/gnU3dLnftD8zvpk/lhP0YSG"
            src="https://lib.baomitu.com/Swiper/4.5.0/js/swiper.min.js"></script>
    <script>
        new Swiper('.swiper-container', {
            autoplay: true,
            effect: 'fade',
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>

@endsection