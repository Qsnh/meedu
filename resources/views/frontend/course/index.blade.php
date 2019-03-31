@extends('layouts.app')

@section('content')

    <header class="header header-inverse">
        <div class="header-info">
            <div class="left">
                <h2 class="header-title"><strong>课程中心</strong></h2>
            </div>
        </div>

        <div class="header-action">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tab-profile" role="tab">全部课程</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tab-messages" role="tab">最新视频</a>
                </li>
                <li class="nav-item d-none d-sm-block">
                    <a class="nav-link" data-toggle="tab" href="#tab-settings" role="tab">搜索结果</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container pt-40 pb-20">
        <div class="row">
            @foreach($courses as $course)
                <div class="col-sm-4">
                    <div class="card">
                        <img class="card-img-top" src="{{ image_url($course->thumb) }}" alt="{{$course->title}}">
                        <div class="card-body">
                            <h4 class="card-title b-0 px-0">
                                <a href="{{ route('course.show', [$course->id, $course->slug]) }}">{{$course->title}}</a>
                            </h4>
                            <p><small>最后更新：{{$course->updated_at->diffForHumans()}}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="container pb-40">
        <div class="row">
            <div class="col-sm-12">{{$courses->render()}}</div>
        </div>
    </div>

@endsection