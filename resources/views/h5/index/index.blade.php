@extends('layouts.h5')

@section('css')
    <link crossorigin="anonymous" integrity="sha384-K6LrEaceM4QP87RzJ7R4CDXcFN4cFW/A5Q7/fEp/92c2WV+woVw9S9zKDO23sNS+"
          href="https://lib.baomitu.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
    <style>
        body {
            background-color: white;
        }
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
                    @include('h5.components.course', ['course' => $course])
                @endforeach
            </div>
        </div>
    @endforeach

    @include('h5.components.tabbar', ['active' => 'index'])

@endsection

@section('js')
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