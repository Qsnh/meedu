@extends('layouts.app')

@section('css')
    <style>
        #xiaoteng-player {
            width: 100%;
            height: 500px;
        }

        .video-item-active {
            color: #33cabb;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid bg-dark mb-30">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-10 play-box no-padding">
                        @auth()
                            @if($canSeeVideo)
                                @if($video['aliyun_video_id'])
                                    @include('components.frontend.aliyun_player', ['video' => $video])
                                @elseif($video['tencent_video_id'])
                                    @include('components.frontend.tencent_player', ['video' => $video])
                                @else
                                    @include('components.frontend.xg_player', ['video' => $video])
                                @endif
                            @else
                                <div style="padding-top: 200px;">
                                    @if($video['charge'] > 0)
                                        <p class="text-center">
                                            <a href="{{ route('member.video.buy', [$video['id']]) }}"
                                               class="btn btn-primary">购买此视频 ￥{{$video['charge']}}</a>
                                        </p>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="col-sm-10 play-box text-center">
                                <a class="btn btn-primary mt-200" href="{{route('login')}}">登录</a>
                            </div>
                        @endauth
                    </div>
                    <div class="col-sm-2 bg-white pt-10 pb-10">
                        <div class="media-list media-list-divided scrollable ps-container ps-theme-default ps-active-y"
                             style="height: 480px;">
                            @if($chapters)
                                @foreach($chapters as $chapter)
                                    <h5 class="bl-2 border-primary pl-1 text-primary">{{$chapter['title']}}</h5>
                                    <div class="media-list-body">
                                        @foreach($videos[$chapter['id']] ?? [] as $videoItem)
                                            <a class="media media-single"
                                               href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                                <h5 class="title {{$videoItem['id'] == $video['id'] ? 'video-item-active' : ''}}">
                                                    {{$videoItem['title']}}
                                                    @if($videoItem['charge'] > 0)
                                                        <br><span class="badge badge-primary">Pro</span></br>
                                                    @endif
                                                </h5>
                                                <time>{{duration_humans($videoItem['duration'])}}</time>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach

                            @else

                                @foreach($videos[0] ?? [] as $videoItem)
                                    <a class="media media-single"
                                       href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                        <h6 class="title {{$videoItem['id'] == $video['id'] ? 'video-item-active' : ''}}">
                                            {{$videoItem['title']}}
                                            @if($videoItem['charge'] > 0)
                                                <br><span class="badge badge-primary">Pro</span></br>
                                            @endif
                                        </h6>
                                        <time>{{duration_humans($videoItem['duration'])}}</time>
                                    </a>
                                @endforeach

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <p>{{ $video['short_description'] }}</p>
                        <p>{{$video['published_at']}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.frontend.comment', ['submitUrl' => route('ajax.video.comment', ['id' => $video['id']]), 'comments' => $comments, 'users' => $commentUsers])

@endsection

@section('js')
    <script>
        $(function () {
            $('#xiaoteng-player').on('contextmenu', function (e) {
                e.preventDefault();
                return false;
            });
        });
    </script>
@endsection