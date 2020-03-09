@extends('layouts.h5')

@section('css')
    <style>
        body {
            padding-top: 40px;
        }
    </style>
@endsection

@section('content')

    @include('h5.components.topbar', ['back' => route('course.show', [$course['id'], $course['slug']]), 'title' => '详情'])

    <div class="video-play-box">
        @if($user)
            @if($canSeeVideo)
                <div class="box-shadow1">
                    @if($video['aliyun_video_id'])
                        @include('h5.components.player.aliyun', ['video' => $video])
                    @elseif($video['tencent_video_id'])
                        @include('h5.components.player.tencent', ['video' => $video])
                    @else
                        @include('h5.components.player.aliyunSimple', ['video' => $video])
                    @endif
                </div>
            @else
                <div style="margin-top: 60px;">
                    <a href="{{ route('member.course.buy', [$course['id']]) }}"
                       class="btn btn-primary mt-1">购买课程</a>
                </div>
            @endif
        @else
            <div style="margin-top: 60px;">
                <a class="btn btn-primary" href="{{route('login')}}">登录</a>
            </div>
        @endif
    </div>
    <div class="container-fluid float-left py-4 mb-3 bg-fff">
        <div class="row">
            <div class="col-12">
                <div class="video-title">
                    {{$video['title']}}
                </div>
            </div>
        </div>
    </div>

    <div class="page-chapter" style="display: block">
        @if($chapters)
            @foreach($chapters as $chapter)
                <div class="chapter-title"><span>{{$chapter['title']}}</span></div>
                <div class="chapter-list-box">
                    @foreach($videos[$chapter['id']] ?? [] as $videoItem)
                        <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                           class="chapter-list-item {{$video['id'] === $videoItem['id'] ? 'active' : ''}}"><span>{{$videoItem['title']}}</span></a>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="chapter-list-box">
                @foreach($videos[0] ?? [] as $videoItem)
                    <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                       class="chapter-list-item {{$video['id'] === $videoItem['id'] ? 'active' : ''}}"><span>{{$videoItem['title']}}</span></a>
                @endforeach
            </div>
        @endif
    </div>

@endsection