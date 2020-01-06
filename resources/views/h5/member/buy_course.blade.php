@extends('h5.app-notab')

@section('content')
    @if($records->total() > 0)
        <div class="weui-panel weui-panel_access">
            <div class="weui-panel__bd">
                @foreach($records as $record)
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
    @else
        @include('h5.components.none')
    @endif

@endsection