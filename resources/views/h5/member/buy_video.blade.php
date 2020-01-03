@extends('h5.app-notab')

@section('content')

    @if($records->total() > 0)
        <div class="weui-panel">
            <div class="weui-panel__bd">
                @foreach($records as $record)
                    @if(!($video = $videos[$record['video_id']] ?? []))
                        @continue
                    @endif
                    <div class="weui-media-box weui-media-box_text">
                        <h4 class="weui-media-box__title">
                            <a href="{{ route('video.show', [$video['course']['id'], $video['id'], $video['slug']]) }}">{{$video['title']}}</a>
                        </h4>
                        <p class="weui-media-box__desc">{{$video['short_description']}}</p>
                        <ul class="weui-media-box__info">
                            <li class="weui-media-box__info__meta">
                                <a href="{{ route('course.show', [$video['course']['id'], $video['course']['slug']]) }}">{{$video['course']['title']}}</a>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        @include('h5.components.none')
    @endif

@endsection