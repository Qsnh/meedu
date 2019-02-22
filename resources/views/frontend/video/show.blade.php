@extends('layouts.app')

@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
@endsection

@section('content')

    @include('components.frontend.bind_mobile_alert')

    <div class="container-fluid video-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9 play-box">
                            @if(Auth::check())
                                @if($user->canSeeThisVideo($video))
                                    <div id="xiaoteng-player"></div>
                                    <script>
                                        $(function () {
                                            var player = new Player({
                                                id: 'xiaoteng-player',
                                                url: '{{$video->getPlayUrl()}}',
                                                fluid: true,
                                                playbackRate: [0.5, 0.75, 1, 1.5, 2],
                                                download: false,
                                                enterLogo:{
                                                    url: '/images/player-logo.png',
                                                    width: 200,
                                                    height: 100
                                                },
                                            });
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
                            @else
                                <div class="col-sm-9 play-box">
                                    <h2 class="text-center" style="line-height: 300px;">
                                        <a href="{{ route('login') }}">点我登陆</a>
                                    </h2>
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-3 play-list" id="play-list-box">
                            <table>
                                @if($position = 0)@endif
                                @if($i = 0)@endif
                                @if($video->course->hasChapters())
                                    @foreach($video->course->getChaptersCache() as $chapter)
                                        <tr class="chapter-title">
                                            <td colspan="2"><span>{{$chapter->title}}</span></td>
                                        </tr>
                                        @foreach($chapter->getVideosCache() as $index => $videoItem)
                                            @if($i++)@endif
                                            @if($video->id == $videoItem->id)
                                                @if($position = $i)@endif
                                            @endif
                                            <tr class="{{$video->id == $videoItem->id ? 'active' : ''}}">
                                                <td class="index">{{$i}}</td>
                                                <td>
                                                    <p class="video-title">
                                                        <a href="{{ route('video.show', [$videoItem->course->id, $videoItem->id, $videoItem->slug]) }}">
                                                            @if($videoItem->charge > 0)
                                                                <i class="fa fa-lock" aria-hidden="true"></i>
                                                            @else
                                                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                                            @endif
                                                            {{ $videoItem->title }}
                                                        </a>
                                                    </p>
                                                    <p class="extra">
                                                        <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{duration_humans($videoItem)}}</span>
                                                        <span><i class="fa fa-play-circle-o" aria-hidden="true"></i> {{ view_num_humans($videoItem) }}</span>
                                                    </p>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                @else

                                    @foreach($video->course->getAllPublishedAndShowVideosCache() as $index => $videoItem)
                                        @if($video->id == $videoItem->id)
                                            @if($position = $index)@endif
                                        @endif
                                        <tr class="{{$video->id == $videoItem->id ? 'active' : ''}}">
                                            <td class="index">{{$index+1}}</td>
                                            <td>
                                                <p class="video-title">
                                                    <a href="{{ route('video.show', [$videoItem->course->id, $videoItem->id, $videoItem->slug]) }}">
                                                        @if($videoItem->charge > 0)
                                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                                        @endif
                                                        {{ $videoItem->title }}
                                                    </a>
                                                </p>
                                                <p class="extra">
                                                    <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{duration_humans($videoItem)}}</span>
                                                    <span><i class="fa fa-play-circle-o" aria-hidden="true"></i> {{ view_num_humans($videoItem) }}</span>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </table>
                        </div>
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
                                <div class="col-sm-12 mt-4">
                                    <h3></h3>
                                    <p class="color-gray">{{ $video->short_description }}</p>
                                </div>

                                <div class="social-share mb-4"></div>

                                <hr>

                                @include('components.frontend.comment_box', ['submitUrl' => route('ajax.video.comment', $video)])

                            </div>
                        </div>
                    </div>

                    @include('components.frontend.comment_list', ['comments' => $comments, 'url' => route('ajax.video.comments', $video)])

                </div>

            </div>

            <div class="col-sm-3 video-play-right-box">
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/js/social-share.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/xgplayer@1.1.3/browser/index.js" type="text/javascript"></script>
    @include('components.frontend.emoji')
    <script>
        document.getElementById('play-list-box').scrollTop = {{$position*56}};
        $('#xiaoteng-player').on('contextmenu', function (e) {
            e.preventDefault();
            return false;
        });
    </script>
@endsection