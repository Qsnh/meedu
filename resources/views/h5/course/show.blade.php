@extends('h5.app')

@section('css')
    <style>
        .tab-item.active {
            color: #0ac590;
            font-size: 1rem;
        }
    </style>
@endsection

@section('content')

    <div class="weui-flex bg-fff">
        <div class="weui-flex__item">
            <p><img src="{{$course['thumb']}}" width="100%" height="240"></p>
            <h4 style="padding: 10px;">{{$course['title']}}</h4>
            <p style="padding: 5px 15px; color: #a3a3a3; font-size: .7rem;">{{$course['short_description']}}</p>
        </div>
    </div>

    <div class="weui-flex bg-fff"
         style="text-align: center; line-height: 50px; margin-top: 14px; font-size: .9rem; border-bottom: 1px solid #efefef;">
        <div class="weui-flex__item tab-item active" data-tab="description">
            介绍
        </div>
        <div class="weui-flex__item tab-item" data-tab="menus">
            目录
        </div>
    </div>
    <div class="weui-flex bg-fff">
        <div class="weui-flex__item description" style="padding: 10px;">
            {!! $course['render_desc'] !!}
        </div>
        <div class="weui-flex__item menus" style="display: none">
            @if($chapters)
                @foreach($chapters as $chapter)
                    <div class="weui-panel" style="margin-top: 0px;">
                        <div class="weui-panel__hd">{{$chapter['title']}}</div>
                        <div class="weui-panel__bd">
                            @foreach($videos[$chapter['id']] ?? [] as $video)
                                <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                    <div class="weui-media-box weui-media-box_text" style="border-bottom: 1px solid #efefef;">
                                        <h4 class="weui-media-box__title">{{$video['title']}}</h4>
                                        <p class="weui-media-box__desc">{{$video['short_description']}}</p>
                                        <ul class="weui-media-box__info">
                                            <li class="weui-media-box__info__meta">{{duration_humans($video['duration'])}}</li>
                                            <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">￥{{$video['charge']}}</li>
                                        </ul>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            @else

                <div class="weui-panel">
                    <div class="weui-panel__bd">
                        @foreach($videos[0] ?? [] as $video)
                            <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                <div class="weui-media-box weui-media-box_text" style="border-bottom: 1px solid #efefef;">
                                    <h4 class="weui-media-box__title">{{$video['title']}}</h4>
                                    <p class="weui-media-box__desc">{{$video['short_description']}}</p>
                                    <ul class="weui-media-box__info">
                                        <li class="weui-media-box__info__meta">{{duration_humans($video['duration'])}}</li>
                                        <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">￥{{$video['charge']}}</li>
                                    </ul>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            @endif
        </div>
    </div>

    <script>
        $(function () {
            $('.tab-item').click(function () {
                $(this).addClass('active').siblings().removeClass('active');
                var tab = $(this).attr('data-tab');
                $('.' + tab).show().siblings().hide();
            });
        });
    </script>

@endsection