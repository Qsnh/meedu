@extends('layouts.h5')

@section('css')
    <style>
        body {
            padding-top: 40px;
        }
    </style>
@endsection

@section('content')

    @include('h5.components.topbar', ['back' => route('courses'), 'title' => '课程详情'])

    <div class="course-thumb mb-3">
        <img src="{{$course['thumb']}}" width="100%" height="192">
    </div>
    <div class="container-fluid float-left py-4 bg-fff">
        <div class="row">
            <div class="col-12">
                <div class="course-info-box">
                    <div class="course-title">{{$course['title']}}</div>
                    <div class="course-info">
                        <span class="user_count">已有{{$course['user_count']}}人订购</span>
                        <span class="price"><small>￥</small>{{$course['charge']}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="course-detail-menu">
        <div class="course-menu-item active" data-page="page-desc">
            <span>课程介绍</span>
        </div>
        <div class="course-menu-item" data-page="page-chapter">
            <span>课程目录</span>
        </div>
    </div>

    <div class="w-100 float-left" style="margin-bottom: 70px;">
        <div class="container-fluid bg-fff py-3 float-left page-desc">
            <div class="row">
                <div class="col-12">
                    {!! $course['render_desc'] !!}
                </div>
            </div>
        </div>
        <div class="page-chapter">
            @if($chapters)
                @foreach($chapters as $chapter)
                    <div class="chapter-title"><span>{{$chapter['title']}}</span></div>
                    <div class="chapter-list-box">
                        @foreach($videos[$chapter['id']] ?? [] as $video)
                            <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                               class="chapter-list-item"><span>{{$video['title']}}</span></a>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="chapter-list-box">
                    @foreach($videos[0] ?? [] as $video)
                        <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                           class="chapter-list-item"><span>{{$video['title']}}</span></a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    @if($isBuy)
        <a href="{{route('member.course.buy', [$course['id']])}}" class="bottom-nav">购买课程</a>
    @else
        <a href="javascript:void(0)" class="bottom-nav">已订阅</a>
    @endif

@endsection