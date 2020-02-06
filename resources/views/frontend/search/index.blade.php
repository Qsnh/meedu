@extends('layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="fw-400 mb-4 c-primary">搜索结果
                    <small class="fs-14px c-2">只显示最近的20条数据</small>
                </h2>
            </div>
            @foreach($courses as $courseItem)
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

    @include('frontend.components.recom_courses')

@endsection