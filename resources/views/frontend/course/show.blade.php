@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>{{ $course->title }}</strong>
                <small>
                    @if($course->charge)
                        <span class="badge badge-danger">价格 {{$course->charge}}元</span>
                    @else
                        <span class="badge badge-success">免费</span>
                    @endif
                </small>
            </h1>

        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#intro">课程介绍</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#videos">视频列表</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="intro">
                                {!! $course->getDescription() !!}
                            </div>
                            <div class="tab-pane fade" id="videos">
                                <div class="media-list media-list-divided">
                                    @if($course->hasChaptersCache())
                                        @foreach($course->getChaptersCache() as $chapter)
                                            <h5 class="bl-2 border-primary pl-1 text-primary">{{$chapter->title}}</h5>
                                            <div class="media-list-body">
                                                @foreach($chapter->getVideosCache() as $video)
                                                    <a class="media media-single" href="{{route('video.show', [$video->course_id, $video->id, $video->slug])}}">
                                                        <h5 class="title">
                                                            {{$video->title}}
                                                            @if($videoItem->charge > 0)<br><span class="badge badge-primary">Pro</span></br>@endif
                                                        </h5>
                                                        <time datetime="{{$video->published_at}}">{{$video->published_at->diffForHumans()}}</time>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach

                                        @else

                                        @foreach($course->getAllPublishedAndShowVideosCache() as $video)
                                            <a class="media media-single" href="{{route('video.show', [$video->course_id, $video->id, $video->slug])}}">
                                                <h6 class="title">
                                                    {{$video->title}}
                                                    @if($videoItem->charge > 0)<br><span class="badge badge-primary">Pro</span></br>@endif
                                                </h6>
                                                <time datetime="{{$video->published_at}}">{{$video->published_at->diffForHumans()}}</time>
                                            </a>
                                        @endforeach

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.frontend.comment', ['submitUrl' => route('ajax.course.comment', $course), 'comments' => $comments])

@endsection