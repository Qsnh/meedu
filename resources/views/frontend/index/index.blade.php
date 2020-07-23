@extends('layouts.app')

@section('css')
    <link crossorigin="anonymous" integrity="sha384-K6LrEaceM4QP87RzJ7R4CDXcFN4cFW/A5Q7/fEp/92c2WV+woVw9S9zKDO23sNS+"
          href="https://lib.baomitu.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 71px;
        }

        .nav-box {
            position: fixed;
            top: 0;
            z-index: 999;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid slider-box">
        <div class="container">
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
                @if($gAnnouncement)
                    <div class="col-12">
                        <div class="announcement-box">
                            <a href="{{route('announcement.show', [$gAnnouncement['id']])}}">{{$gAnnouncement['title']}}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @foreach($banners as $i => $banner)
        <div class="container-fluid index-latest-banner {{$i % 2 === 0 ? 'bg-fff' : ''}}">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="banner-title">
                            <img src="/images/icons/index-banner-course.png" width="38" height="35">
                            <span class="title">{{$banner['name']}}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="course-list-box">
                            @foreach($banner['courses'] as $index => $course)
                                @include('frontend.components.course-item', ['course' => $course, 'class' => (($index + 1) % 4 == 0) ? 'last' : ''])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

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