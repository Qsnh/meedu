@extends('h5.app')

@section('css')
    <style>
        .tab-item.active {
            color: #0ac590;
            font-size: 1rem;
        }

        #xiaoteng-player {
            width: 100%;
            height: 300px;
            background-color: #000;
        }

        .video-item-{{$video['id']}} {
            color: #0ac590;
        }
    </style>
@endsection

@section('content')

    <div class="weui-flex">
        <div class="weui-flex__item">
            @if($user)
                @if($canSeeVideo)
                    @if($video['aliyun_video_id'])
                        @include('h5.components.players.aliyun_player', ['video' => $video])
                    @elseif($video['tencent_video_id'])
                        @include('h5.components.players.tencent_player', ['video' => $video])
                    @else
                        @include('h5.components.players.xg_player', ['video' => $video])
                    @endif
                @else
                    <div style="padding-top: 100px; padding-bottom: 100px; background-color: #000">
                        @if($video['charge'] > 0)
                            <p class="text-center">
                                <a href="{{ route('member.video.buy', [$video['id']]) }}"
                                   class="weui-btn weui-btn_primary">购买此视频 ￥{{$video['charge']}}</a>
                            </p>
                        @endif
                    </div>
                @endif
            @else
                <div style="padding-top: 100px; padding-bottom: 100px; background-color: #000">
                    <a class="weui-btn weui-btn_primary" href="{{route('login')}}">登录</a>
                </div>
            @endif
        </div>
    </div>

    <div class="weui-flex bg-fff" style="margin-top: 14px;">
        <div class="weui-flex__item">
            <h4 style="padding: 10px;">{{$video['title']}}</h4>
            <p style="padding: 5px 15px; color: #a3a3a3; font-size: .7rem;">{{$video['short_description']}}</p>
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
            {!! $video['render_desc'] !!}
        </div>
        <div class="weui-flex__item menus" style="display: none">
            @if($chapters)
                @foreach($chapters as $chapter)
                    <div class="weui-panel" style="margin-top: 0px;">
                        <div class="weui-panel__hd">{{$chapter['title']}}</div>
                        <div class="weui-panel__bd">
                            @foreach($videos[$chapter['id']] ?? [] as $videoItem)
                                <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                    <div class="weui-media-box weui-media-box_text"
                                         style="border-bottom: 1px solid #efefef;">
                                        <h4 class="weui-media-box__title video-item-{{$videoItem['id']}}">{{$videoItem['title']}}</h4>
                                        <p class="weui-media-box__desc">{{$videoItem['short_description']}}</p>
                                        <ul class="weui-media-box__info">
                                            <li class="weui-media-box__info__meta">{{duration_humans($videoItem['duration'])}}</li>
                                            <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">
                                                ￥{{$videoItem['charge']}}</li>
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
                        @foreach($videos[0] ?? [] as $videoItem)
                            <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                <div class="weui-media-box weui-media-box_text"
                                     style="border-bottom: 1px solid #efefef;">
                                    <h4 class="weui-media-box__title video-item-{{$videoItem['id']}}">{{$videoItem['title']}}</h4>
                                    <p class="weui-media-box__desc">{{$videoItem['short_description']}}</p>
                                    <ul class="weui-media-box__info">
                                        <li class="weui-media-box__info__meta">{{duration_humans($videoItem['duration'])}}</li>
                                        <li class="weui-media-box__info__meta weui-media-box__info__meta_extra">
                                            ￥{{$videoItem['charge']}}</li>
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