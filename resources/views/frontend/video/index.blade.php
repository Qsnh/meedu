@extends('layouts.app')

@section('content')

    <header class="header header-inverse">
        <div class="header-info">
            <div class="left">
                <h2 class="header-title"><strong>全部视频</strong></h2>
            </div>

            <div class="right">
                <form class="lookup lookup-circle lookup-lg lookup-right" action="{{route('search')}}" method="get">
                    @csrf
                    <input type="text" name="keywords">
                </form>
            </div>
        </div>

        <div class="header-action">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('courses')}}" role="tab">全部课程</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('videos')}}" role="tab">最新视频</a>
                </li>
                <li class="nav-item d-none d-sm-block">
                    <a class="nav-link" href="#tab-settings" role="tab">搜索结果</a>
                </li>
            </ul>
        </div>
    </header>

    <div class="container pt-40 pb-20">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="media-list media-list-hover media-list-divided">
                        @foreach($videos as $video)
                        <a class="media media-single" href="{{route('video.show', [$video->course_id, $video->id, $video->slug])}}">
                            <h5 class="title">{{$video->title}}</h5>
                            <time datetime="{{$video->published_at}}">{{$video->published_at->diffForHumans()}}</time>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-40">
        <div class="row">
            <div class="col-sm-12">{{$videos->render()}}</div>
        </div>
    </div>

@endsection