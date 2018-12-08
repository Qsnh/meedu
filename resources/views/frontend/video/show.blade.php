@extends('layouts.app')

@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
    <link crossorigin="anonymous" integrity="sha384-ccp+s0mORr8liSoaAJidjC9nKr4h7Oc6fXmvPdx5d+Lpjc31GfaOKtF8UCCQrEnS" href="https://lib.baomitu.com/video.js/7.4.0/video-js.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container-fluid video-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9 play-box">
                            @if(Auth::check())
                                @if($user->canSeeThisVideo($video))
                                    <video id="xiaoteng-player" class="video-js vjs-default-skin"
                                           controls preload="auto" data-setup='{ "playbackRates": [1, 1.5, 2] }'>
                                        <source src="{{$video->getPlayUrl()}}" type="video/mp4">
                                    </video>
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
                                                        <a href="{{ route('video.show', [$video->course->id, $videoItem->id, $videoItem->slug]) }}">
                                                            {{ $videoItem->title }}
                                                        </a>
                                                    </p>
                                                    <p class="extra">
                                                        @if($video->charge > 0)
                                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                                        @endif
                                                        <span>更新于：{{ $video->updated_at->diffForHumans() }}</span>
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
                                            <a href="{{ route('video.show', [$video->course->id, $videoItem->id, $videoItem->slug]) }}">
                                                {{ $videoItem->title }}
                                            </a>
                                        </p>
                                        <p class="extra">
                                            @if($video->charge > 0)
                                                <i class="fa fa-lock" aria-hidden="true"></i>   
                                                @else
                                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                            @endif
                                            <span>更新于：{{ $video->updated_at->diffForHumans() }}</span>
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
    <script crossorigin="anonymous" integrity="sha384-/e2pbP9gABPxsNYBS/MkAotgW5kbTdaJ4iXyVfbjGNEyvB4Q3p1vUQhLRJBmJqc8" src="https://lib.baomitu.com/video.js/7.4.0/video.min.js"></script>
    @include('components.frontend.emoji')
    @include('components.frontend.comment_js')
    <script>
        $(function () {
            $('#play-list-box').scrollTop = {{$position*56}};
        });
    </script>
@endsection