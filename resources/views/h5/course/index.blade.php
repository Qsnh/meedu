@extends('h5.app')

@section('content')

    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">全部课程</div>
        <div class="weui-panel__bd">
            @foreach($courses as $course)
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
    </div>

@endsection