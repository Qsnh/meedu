<div class="index-banner-box">
    <div class="banner-title">{{$block['config_render']['title']}}</div>
    <div class="courses">
        @foreach($block['config_render']['items'] as $index => $course)
            @continue(!$course['id'])
            @include('h5.components.course', ['course' => $course])
        @endforeach
    </div>
</div>