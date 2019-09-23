@extends('layouts.app')

@section('css')
    <style>
        #xiaoteng-player {width: 100%; height: 500px;}
        .video-item-active { color: #33cabb; }
    </style>
@endsection

@section('content')

    <div class="container-fluid bg-dark mb-30">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-10 play-box no-padding">
                        @auth()
                            @if($user->canSeeThisVideo($video))
                                @if($video->aliyun_video_id)
                                    @include('components.frontend.aliyun_player', ['video' => $video])
                                @elseif($video->tencent_video_id)
                                    @include('components.frontend.tencent_player', ['video' => $video])
                                @else
                                    @include('components.frontend.xg_player', ['video' => $video])
                                @endif
                            @else
                                <div style="padding-top: 200px;">
                                    @if($video->charge > 0 && $video->course->charge == 0)
                                        <p class="text-center">
                                            <a href="{{ route('member.video.buy', $video) }}"
                                               class="btn btn-primary">购买此视频 ￥{{$video->charge}}</a>
                                        </p>
                                    @endif
                                    @if($video->course->charge > 0)
                                        <p class="text-center">
                                            <a href="{{ route('member.course.buy', $video->course->id) }}"
                                               class="btn btn-danger">购买此套课程 ￥{{$video->course->charge}}</a>
                                        </p>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="col-sm-10 play-box">
                                <p class="text-center mt-200"><a class="btn btn-primary" href="{{route('login')}}">前去登录</a></p>
                            </div>
                        @endauth
                    </div>
                    <div class="col-sm-2 bg-white pt-10 pb-10">
                        <div class="media-list media-list-divided scrollable ps-container ps-theme-default ps-active-y" style="height: 480px;">
                            @if($video->course->hasChaptersCache())
                                @foreach($video->course->getChaptersCache() as $chapter)
                                    <h5 class="bl-2 border-primary pl-1 text-primary">{{$chapter->title}}</h5>
                                    <div class="media-list-body">
                                        @foreach($chapter->getVideosCache() as $videoItem)
                                            <a class="media media-single {{$videoItem->id == $video->id ? 'video-item-active' : ''}}"
                                               href="{{route('video.show', [$videoItem->course_id, $videoItem->id, $videoItem->slug])}}">
                                                <h5 class="title">
                                                    {{$videoItem->title}}
                                                    @if($videoItem->charge > 0)<br><span class="badge badge-primary">Pro</span></br>@endif
                                                </h5>
                                                <time>{{duration_humans($videoItem->duration)}}</time>
                                            </a>
                                        @endforeach
                                    </div>
                                @endforeach

                            @else

                                @foreach($video->course->getAllPublishedAndShowVideosCache() as $videoItem)
                                    <a class="media media-single {{$videoItem->id == $video->id ? 'video-item-active' : ''}}"
                                       href="{{route('video.show', [$videoItem->course_id, $videoItem->id, $videoItem->slug])}}">
                                        <h6 class="title">
                                            {{$videoItem->title}}
                                            @if($videoItem->charge > 0)<br><span class="badge badge-primary">Pro</span></br>@endif
                                        </h6>
                                        <time>{{duration_humans($videoItem->duration)}}</time>
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
                        <p>{{ $video->short_description }}</p>
                        <p>{{$video->created_at->diffForHumans()}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.frontend.comment', ['submitUrl' => route('ajax.video.comment', ['id' => $video->id]), 'comments' => $comments])

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