@extends('h5.app')

@section('content')

    <div class="weui-panel">
        <div class="weui-panel__hd">全部视频</div>
        <div class="weui-panel__bd scroll-wrapper">
            @foreach($videos as $video)
                <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                    <div class="weui-media-box weui-media-box_text">
                        <h4 class="weui-media-box__title">{{$video['title']}}</h4>
                        <p class="weui-media-box__desc">{{$video['short_description']}}</p>
                        <ul class="weui-media-box__info">
                            <li class="weui-media-box__info__meta">{{$video['course']['title']}}</li>
                            <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">
                                {{duration_humans($video['duration'])}}</li>
                        </ul>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection