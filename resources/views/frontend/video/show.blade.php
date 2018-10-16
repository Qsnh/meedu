@extends('layouts.app')

@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.7.2/skins/default/aliplayer-min.css">
@endsection

@section('content')

    <div class="container-fluid video-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row">
                        @if(Auth::check())
                            <div class="col-sm-9 play-box">
                                @if($user->canSeeThisVideo($video))
                                    <div id="player"></div>
                                    <script src="https://g.alicdn.com/de/prismplayer/2.7.2/aliplayer-min.js"></script>
                                    <script>
                                        var player = new Aliplayer({
                                            "id": "player",
                                            "qualitySort": "asc",
                                            "format": "mp4",
                                            "mediaType": "video",
                                            "width": "100%",
                                            "height": "500px",
                                            "autoplay": false,
                                            "isLive": false,
                                            "rePlay": false,
                                            "playsinline": true,
                                            "preload": true,
                                            "autoPlayDelay": 2,
                                            "autoPlayDelayDisplayText": '正在加载中...',
                                            "loadDataTimeout": "",
                                            "controlBarVisibility": "hover",
                                            "useH5Prism": true,
                                            "vid" : '{{$video->aliyun_video_id}}',
                                            "playauth" : '{{aliyun_play_auth($video)}}',
                                        },function(player){
                                        });
                                    </script>
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
                            </div>
                            <div class="col-sm-3 play-list">
                                <ul>
                                    @foreach($video->course->getAllPublishedAndShowVideosCache() as $index => $videoItem)
                                        <a href="{{ route('video.show', [$video->course->id, $videoItem->id, $videoItem->slug]) }}">
                                            <li data-index="{{ $index }}" class="{{ $videoItem->id == $video->id ? 'active' : '' }}">
                                                <i class="fa fa-play-circle-o" aria-hidden="true"></i> {{ $videoItem->title }}
                                            </li>
                                        </a>
                                    @endforeach
                                </ul>
                            </div>
                            @else
                            <div class="col-sm-12 play-box">
                                <h2 class="text-center" style="line-height: 300px;">
                                    <a href="{{ route('login') }}">点我登陆</a>
                                </h2>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 15px;">
        <div class="row">
            <div class="col-sm-9 video-play-comment-box">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                {{ $video->title }}
                            </div>
                            <div class="card-body">
                                <div class="col-sm-12" style="margin-bottom: 20px;">
                                    <h3></h3>
                                    <p class="color-gray">{{ $video->short_description }}</p>
                                </div>

                                <div class="social-share" style="margin-bottom: 10px;"></div>

                                <hr>

                                @include('components.frontend.comment_box', ['submitUrl' => route('video.comment', $video)])

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12" style="margin-top: 15px; margin-bottom: 15px;">
                        <div class="card">
                            <div class="card-header">
                                评论内容
                            </div>
                            <div class="card-body">
                                <table class="comment-list-box">
                                    <tbody>
                                    @forelse($video->comments as $comment)
                                    <tr class="comment-list-item">
                                        <td width="70" class="user-info">
                                            <p><img class="avatar" src="{{$comment->user->avatar}}" width="50" height="50"></p>
                                            <p class="nickname">{{$comment->user->nick_name}}</p>
                                            @if($comment->user->role)
                                            <p class="nickname">{{$comment->user->role->name}}</p>
                                            @endif
                                        </td>
                                        <td class="comment-content">
                                            <p>{!! $comment->getContent() !!}</p>
                                            <p class="text-right color-gray">{{$comment->created_at->diffForHumans()}}</p>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center color-gray" colspan="2">0评论</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-sm-3 video-play-right-box">

            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/social-share.min.js"></script>
    @include('components.frontend.emoji')
    @include('components.frontend.comment_js')
@endsection