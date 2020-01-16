@extends('layouts.app')

@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-f6">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">首页</a></li>
                        <li class="breadcrumb-item"><a href="{{route('courses')}}">全部课程</a></li>
                        <li class="breadcrumb-item active" aria-current="page">课程详情</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container pb-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="w-100 float-left box-shadow1">
                    <img src="{{$course['thumb']}}" width="100%" height="284" class="br-8">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="row">
                    <div class="col-12 py-2">
                        <div class="w-100 float-left">
                            <h2 class="fw-400">{{$course['title']}}</h2>
                        </div>
                    </div>
                    <div class="col-md-8 col-12 pb-3">
                        <div class="w-100 bg-fff py-2 br-8 float-left">
                            <table class="table border-0">
                                <tr>
                                    <td width="32%" class="text-center border-0"><i class="fa fa-money"></i> 价格</td>
                                    <td class="border-0">￥{{$course['charge']}}</td>
                                </tr>
                                <tr>
                                    <td class="text-center border-0"><i class="fa fa-clock-o"></i> 上架</td>
                                    <td class="border-0">{{\Carbon\Carbon::parse($course['published_at'])->format('Y/m/d')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-center border-0"><i class="fa fa-comment-o"></i> 简介</td>
                                    <td class="border-0">{{$course['short_description']}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="w-100 float-left">
                            @if($course['charge'] > 0)
                                <a href="{{route('member.course.buy', [$course['id']])}}" class="btn btn-success btn-block py-2">购买此课程 ￥{{$course['charge']}}</a>
                            @endif
                            <a href="#课程详情" class="btn btn-secondary btn-block py-2">课程详情</a>
                            <a href="#课程目录" class="btn btn-secondary btn-block py-2">课程目录</a>
                            <a href="#课程评论" class="btn btn-secondary btn-block py-2">课程评论</a>
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