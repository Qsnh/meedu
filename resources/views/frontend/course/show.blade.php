@extends('layouts.app')

@section('content')

    <div class="course-fixed-menu">
        <a href="#课程详情" class="course-fixed-menu-item">详情</a>
        <a href="#课程目录" class="course-fixed-menu-item">目录</a>
        <a href="#课程评论" class="course-fixed-menu-item">评论</a>
    </div>

    <div class="container-fluid course-detail-banner pb-3">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">首页</a></li>
                            <li class="breadcrumb-item"><a href="{{route('courses')}}">全部课程</a></li>
                            <li class="breadcrumb-item active" aria-current="page">课程详情</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex flex-column flex-lg-row w-100 course-detail">
                        <div class="course-detail-thumb">
                            <img src="{{$course['thumb']}}" width="510" height="384">
                        </div>
                        <div class="course-detail-thumb-sm">
                            <img src="{{$course['thumb']}}">
                        </div>
                        <div class="course-detail-box flex-grow-1">
                            <div class="course-detail-title">
                                <h3>{{$course['title']}}</h3>
                            </div>
                            <div class="course-detail-info fs-14px mb-3">
                                <span>上架时间：{{\Carbon\Carbon::parse($course['published_at'])->format('Y/m/d')}}</span>
                            </div>
                            <div class="course-detail-desc py-2 fs-14px">
                                {{$course['short_description']}}
                            </div>
                            <div class="course-detail-price text-right">
                                @if($course['charge'] > 0 && !$isBuy)
                                    <a href="{{route('member.course.buy', [$course['id']])}}" class="btn btn-primary">
                                        立即购买 ￥{{$course['charge']}}
                                    </a>
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
                            <h3 id="课程详情" class="fw-400 mb-4 c-primary">课程详情</h3>
                            <div class="w-100 float-left">
                                {!! $course['render_desc'] !!}
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
                                            @foreach($videos[$chapter['id']] ?? [] as $video)
                                                <dd class="d-inline-block w-100 float-left border-bottom border-secondary mb-0">
                                                    <a class="d-inline-block w-100 float-left py-2"
                                                       href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                                        <span class="float-left ml-3">
                                                            <i class="fa fa-play-circle-o"></i> {{$video['title']}}
                                                            @if($video['charge'] > 0)
                                                                <span class="badge badge-primary">PRO</span>
                                                            @else
                                                                <span class="badge badge-success">FREE</span>
                                                            @endif
                                                        </span>
                                                        <span class="float-right mr-3"><i class="fa fa-clock-o"></i> {{duration_humans($video['duration'])}}</span>
                                                    </a>
                                                </dd>
                                            @endforeach
                                        @endforeach
                                    </dl>

                                @else

                                    <dl class="fs-14px d-inline-block float-left w-100">
                                        @foreach($videos[0] ?? [] as $video)
                                            <dd class="d-inline-block w-100 float-left border-bottom border-secondary mb-0">
                                                <a class="d-inline-block w-100 float-left py-2"
                                                   href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                                        <span class="float-left ml-3">
                                                            <i class="fa fa-play-circle-o"></i> {{$video['title']}}
                                                            @if($video['charge'] > 0)
                                                                <span class="badge badge-primary">PRO</span>
                                                            @else
                                                                <span class="badge badge-success">FREE</span>
                                                            @endif
                                                        </span>
                                                    <span class="float-right mr-3"><i class="fa fa-clock-o"></i> {{duration_humans($video['duration'])}}</span>
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
                            <h3 id="课程评论" class="fw-400 mb-4 c-primary">课程评论</h3>
                            <div class="w-100 float-left">
                                @include('frontend.components.comment', ['submitUrl' => route('ajax.course.comment', [$course['id']]), 'comments' => $comments, 'users' => $commentUsers])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection