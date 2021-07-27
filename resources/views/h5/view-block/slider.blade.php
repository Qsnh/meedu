<div class="swiper-box">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($block['config_render'] as $slider)
                <a class="swiper-slide" href="{{$slider['href'] ?? ''}}">
                    <img src="{{$slider['src']}}" width="100%" height="115">
                </a>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>