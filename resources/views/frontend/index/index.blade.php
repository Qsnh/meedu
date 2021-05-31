@extends('frontend.layouts.app')

@section('css')
    <link crossorigin="anonymous" integrity="sha384-K6LrEaceM4QP87RzJ7R4CDXcFN4cFW/A5Q7/fEp/92c2WV+woVw9S9zKDO23sNS+"
          href="https://lib.baomitu.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">
@endsection

@section('content')

    <!-- 公告 -->
    @if($gAnnouncement)
        <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
            <a href="{{route('announcement.show', [$gAnnouncement['id']])}}"
               class="block py-3 rounded bg-blue-500 text-white shadow hover:bg-blue-400 flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-6 w-6" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
                <span class="ml-1">{{$gAnnouncement['title']}}</span>
            </a>
        </div>
    @endif

    @if($sliders)
        <div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
            <div class="swiper-container shadow rounded">
                <div class="swiper-wrapper">
                    @foreach($sliders as $slider)
                        <a class="swiper-slide" href="{{$slider['url']}}">
                            <img src="{{$slider['thumb']}}" class="object-cover rounded" width="100%">
                        </a>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    @endif

    <!-- 首页推荐 -->
    <div class="w-full px-3 pb-6 pt-10 lg:max-w-6xl lg:mx-auto">
        @foreach($banners as $i => $banner)
            <div class="{{$loop->last ? '' : 'mb-16'}}">
                <div class="text-2xl font-bold text-gray-900 mb-14 flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-9 w-9" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="ml-1">{{$banner['name']}}</span>
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
    <div class="w-full px-3 pb-6 pt-10 lg:max-w-6xl lg:mx-auto">
        <div class="text-xl font-bold text-gray-900 mb-6">{{__('友情链接')}}</div>
        <div>
            @foreach($links as $link)
                <a href="{{$link['url']}}" class="mr-5 mb-3 text-gray-500 hover:text-gray-600"
                   target="_blank">{{$link['name']}}</a>
            @endforeach
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