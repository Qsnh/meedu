@extends('layouts.app')

@section('content')

    <div class="container-fluid py-5 index-course-banner">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        @if($gRecCourses)
                            <div class="col-md-6 col-12 text-center pr-2">
                                <a href="{{route('course.show', [$gRecCourses[0]['id'], $gRecCourses[0]['slug']])}}">
                                    <div class="box-shadow1">
                                        <img src="{{$gRecCourses[0]['thumb']}}" width="100%" height="360"
                                             class="br-8"
                                             alt="{{$gRecCourses[0]['title']}}">
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="row">
                                    @foreach($gRecCourses as $index => $courseItem)
                                        @if($index == 0)
                                            @continue
                                        @endif
                                        @if($index == 5)
                                            @break
                                        @endif
                                        <div class="col-md-6 col-12 {{in_array($index, [1, 2]) ? 'pb-10px' : ''}} {{in_array($index, [3, 4]) ? 'pt-10px' : ''}}">
                                            <a href="{{route('course.show', [$courseItem['id'], $courseItem['slug']])}}">
                                                <div class="box-shadow1">
                                                    <img src="{{$courseItem['thumb']}}" width="100%" height="170"
                                                         class="br-8 box-shadow1"
                                                         alt="{{$courseItem['title']}}">
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-fff py-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fw-400 mb-4 c-primary">最新课程
                            </h2>
                            <div class="row">
                                @foreach($gLatestCourses as $index => $courseItem)
                                    @if($index == 8)
                                        @break
                                    @endif
                                    <div class="col-12 col-md-3 pb-24px video-item">
                                        <a href="{{route('course.show', [$courseItem['id'], $courseItem['slug']])}}">
                                            <div class="video-item-box box-shadow1 br-8 t1 float-left">
                                                <div class="video-thumb">
                                                    <div class="video-thumb-img"
                                                         style="background: url('{{$courseItem['thumb']}}') center center no-repeat;background-size: cover;">
                                                    </div>
                                                </div>
                                                <div class="video-title py-3 float-left">
                                                    <span>{{$courseItem['title']}}</span>
                                                </div>
                                                <div class="video-extra pb-3">
                                                    <span class="float-left"><i class="fa fa-file-video-o"></i> {{$courseItem['videos_count']}}</span>
                                                    <span class="float-right">
                                                        @if($courseItem['category'])
                                                            <i class="fa fa-tag"></i> {{$courseItem['category']['name']}}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-f6 py-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <h2 class="fw-400 mb-4 c-primary">套餐 <a href="{{route('role.index')}}" class="fs-14px ml-2">全部套餐</a>
                            </h2>
                        </div>
                        @foreach($gRoles as $index => $roleItem)
                            @if($index == 3)
                                @break
                            @endif
                            <div class="col-md-4 col-12 text-center role-item mb-3">
                                <a href="{{route('member.role.buy', [$roleItem['id']])}}">
                                    <div class="role-item-box px-3 py-5 {{$index == 1 ? 'bg-primary' : 'bg-fff'}} br-8 box-shadow1 t1">
                                        <p class="pb-3 name {{$index == 1 ? 'c-fff' : ''}}">{{$roleItem['name']}}</p>
                                        <p class="price {{$index == 1 ? 'c-fff' : ''}}"><b>￥{{$roleItem['charge']}}</b>
                                        </p>
                                        @foreach($roleItem['desc_rows'] as $item)
                                            <p class="p-0 desc-item {{$index == 1 ? 'c-fff' : ''}}">{{$item}}</p>
                                        @endforeach
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-1 pt-4">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-12 border-bottom link">
                            <h5 class="c-2">友情链接</h5>
                            <p>
                                @foreach($links as $link)
                                    <a href="{{$link['url']}}" target="_blank"
                                       class="m-2 c-2 fs-14px">{{$link['name']}}</a>
                                @endforeach
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection