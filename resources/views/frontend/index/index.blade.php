@extends('frontend.layouts.app')

@section('css')
    <link crossorigin="anonymous" integrity="sha384-K6LrEaceM4QP87RzJ7R4CDXcFN4cFW/A5Q7/fEp/92c2WV+woVw9S9zKDO23sNS+"
          href="https://lib.baomitu.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="w-full px-3 pt-6 lg:max-w-6xl lg:mx-auto">
        <div class="swiper-container rounded-tl rounded-tr">
            <div class="swiper-wrapper">
                @foreach($sliders as $slider)
                    <a class="swiper-slide" href="{{$slider['url']}}">
                        <img src="{{$slider['thumb']}}" class="object-cover rounded-tl rounded-tr" width="100%">
                    </a>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    @if($gAnnouncement)
        <div class="w-full px-3 lg:max-w-6xl lg:mx-auto">
            <a href="{{route('announcement.show', [$gAnnouncement['id']])}}"
               class="block px-6 py-3 rounded-bl rounded-br annon">
                {{$gAnnouncement['title']}}
            </a>
        </div>
    @endif

    <!-- 首页推荐 -->
    <div class="w-full px-3 pt-20 pb-6 lg:max-w-6xl lg:mx-auto">
        @foreach($banners as $i => $banner)
            <div class="mb-20">
                <div class="text-3xl text-gray-900 pb-12 flex justify-center">
                    <i class="iconfont icon-book text-gray-900" style="font-size: 42px;"></i>
                    <span class="ml-3 font-bold">{{$banner['name']}}</span>
                </div>
                <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($banner['courses'] as $index => $course)
                        @include('frontend.components.course-item', ['course' => $course])
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- 友情链接 -->
    <div class="w-full" style="background-color: #0F0B1E">
        <div class="w-full px-3 pb-6 pt-10 lg:max-w-6xl lg:mx-auto">
            <div class="text-xl text-white mb-6">{{__('友情链接')}}</div>
            <div>
                @foreach($links as $link)
                    <a href="{{$link['url']}}" class="mr-5 mb-3 text-gray-500 hover:text-gray-600"
                       target="_blank">{{$link['name']}}</a>
                @endforeach
            </div>
        </div>
    </div>

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