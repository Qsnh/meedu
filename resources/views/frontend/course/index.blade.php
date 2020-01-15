@extends('layouts.app')

@section('content')

    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="w-100 float-left box-shadow1">
                                <a href="{{route('role.index')}}">
                                    <img src="{{asset('frontend/images/vip1.png')}}" class="br-8" height="230"
                                         width="100%">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="w-100 box-shadow1 float-left">
                                <a href="{{route('member.promo_code')}}">
                                    <img src="{{asset('frontend/images/share.png')}}" class="br-8" height="230"
                                         width="100%">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-fff">
        <div class="row">
            <div class="col-12">
                <div class="container my-5">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="fw-400 mb-4 c-primary">全部课程</h2>
                            <div class="row">
                                @foreach($courses as $index => $courseItem)
                                    <div class="col-12 col-md-3 pb-24px video-item">
                                        <a href="{{route('course.show', [$courseItem['id'], $courseItem['slug']])}}">
                                            <div class="video-item-box bg-fff box-shadow1 br-8 t1 float-left">
                                                <div class="video-thumb-direct">
                                                    <img src="{{$courseItem['thumb']}}" class="br-top-8" width="100%"
                                                         height="192">
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
                                                <div class="video-list-box pb-2">
                                                    @foreach($courseItem['videos'] as $index1 => $videoItem)
                                                        @if($index1 == 3)
                                                            @break
                                                        @endif
                                                        <div class="video-list-box-item py-1 overflow-hidden">
                                                            <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                                                <div class="float-left ml-3">
                                                                    <i class="fa fa-play-circle"></i> {{$videoItem['title']}}
                                                                </div>

                                                                <div class="float-right mr-3">
                                                                    <i class="fa fa-clock-o"></i> {{duration_humans($videoItem['duration'])}}
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 my-5">
                            <div class="float-right">
                                {{$courses->render()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection