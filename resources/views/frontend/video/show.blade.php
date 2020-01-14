@extends('layouts.app')

@section('css')
    <style>
        body {
            background-color: #f6f6f6;
        }

        #xiaoteng-player {
            width: 100%;
            height: 500px;
        }
    </style>
@endsection

@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-f6">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">首页</a></li>
                        <li class="breadcrumb-item"><a
                                    href="{{route('course.show', [$course['id'], $course['slug']])}}">{{$course['title']}}</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">视频详情</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="fw-400 py-2">{{$video['title']}}</h2>
                <div class="w-100 float-left">
                    @if($user)
                        @if($canSeeVideo)
                            <div class="box-shadow1">
                                @if($video['aliyun_video_id'])
                                    @include('frontend.components.player.aliyun', ['video' => $video])
                                @elseif($video['tencent_video_id'])
                                    @include('frontend.components.player.tencent', ['video' => $video])
                                @else
                                    @include('frontend.components.player.xg', ['video' => $video])
                                @endif
                            </div>
                        @else
                            <div class="py-5 bg-dark br-8">
                                @if($video['charge'] > 0)
                                    <p class="text-center my-5">
                                        <a href="{{ route('member.video.buy', [$video['id']]) }}"
                                           class="btn btn-primary my-5">购买此视频 ￥{{$video['charge']}}</a>
                                    </p>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="w-100 float-left py-5 bg-dark br-8 box-shadow1 text-center">
                            <p class="my-5">
                                <a class="btn btn-primary my-5 px-4" href="{{route('login')}}">登录</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <h3 id="视频详情" class="fw-400 mb-4 c-primary">视频详情</h3>
                            <div class="w-100 float-left">
                                {!! $video['render_desc'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <h3 id="课程目录" class="fw-400 mb-4 c-primary">课程目录</h3>
                            <div class="course-video-list">
                                @if($chapters)
                                    <dl class="fs-14px d-inline-block float-left w-100">
                                        @foreach($chapters as $chapter)
                                            <dt class="py-2 d-inline-block w-100 float-left fw-400 fs-18px border-bottom border-secondary">
                                                {{$chapter['title']}}
                                            </dt>
                                            @foreach($videos[$chapter['id']] ?? [] as $videoItem)
                                                <dd class="d-inline-block w-100 float-left border-bottom border-secondary mb-0 {{$videoItem['id'] == $video['id'] ? 'active' : ''}}">
                                                    <a class="d-inline-block w-100 float-left py-2"
                                                       href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                                        <span class="float-left ml-3">
                                                            <i class="fa fa-play-circle-o"></i> {{$videoItem['title']}}
                                                            @if($videoItem['charge'] > 0)
                                                                <span class="badge badge-primary">PRO</span>
                                                            @else
                                                                <span class="badge badge-success">FREE</span>
                                                            @endif
                                                        </span>
                                                        <span class="float-right mr-3"><i class="fa fa-clock-o"></i> {{duration_humans($videoItem['duration'])}}</span>
                                                    </a>
                                                </dd>
                                            @endforeach
                                        @endforeach
                                    </dl>

                                @else

                                    <dl class="fs-14px d-inline-block float-left w-100">
                                        @foreach($videos[0] ?? [] as $videoItem)
                                            <dd class="d-inline-block w-100 float-left border-bottom border-secondary mb-0 {{$videoItem['id'] == $video['id'] ? 'active' : ''}}">
                                                <a class="d-inline-block w-100 float-left py-2"
                                                   href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                                        <span class="float-left ml-3">
                                                            <i class="fa fa-play-circle-o"></i> {{$videoItem['title']}}
                                                            @if($videoItem['charge'] > 0)
                                                                <span class="badge badge-primary">PRO</span>
                                                            @else
                                                                <span class="badge badge-success">FREE</span>
                                                            @endif
                                                        </span>
                                                    <span class="float-right mr-3"><i class="fa fa-clock-o"></i> {{duration_humans($videoItem['duration'])}}</span>
                                                </a>
                                            </dd>
                                        @endforeach
                                    </dl>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <h3 id="视频评论" class="fw-400 mb-4 c-primary">视频评论</h3>
                            <div class="w-100 float-left">
                                @include('frontend.components.comment', ['submitUrl' => route('ajax.video.comment', [$video['id']]), 'comments' => $comments, 'users' => $commentUsers])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection