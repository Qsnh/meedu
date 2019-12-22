@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>{{ $course['title'] }}</strong>
                <small>
                    @if($course['charge'])
                        <a class="btn btn-primary btn-sm ml-3" href="{{route('member.course.buy', [$course['id']])}}">
                            购买课程 {{$course['charge']}}元
                        </a>
                    @else
                        <span class="badge badge-primary">免费</span>
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
                                {!! $course['render_desc'] !!}
                            </div>
                            <div class="tab-pane fade" id="videos">
                                <div class="media-list media-list-divided">
                                    @if($chapters)
                                        @foreach($chapters as $chapter)
                                            <h5 class="bl-2 border-primary pl-1 text-primary">{{$chapter['title']}}</h5>
                                            <div class="media-list-body">
                                                @foreach($videos[$chapter['id']] ?? [] as $video)
                                                    <a class="media media-single"
                                                       href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                                        <h5 class="title">
                                                            {{$video['title']}}
                                                            @if($video['charge'] > 0)
                                                                <br><span class="badge badge-primary">Pro</span></br>
                                                            @endif
                                                        </h5>
                                                        <time datetime="{{$video['published_at']}}">{{duration_humans($video['duration'])}}</time>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endforeach

                                    @else

                                        @foreach($videos[0] ?? [] as $video)
                                            <a class="media media-single"
                                               href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                                <h6 class="title">
                                                    {{$video['title']}}
                                                    @if($video['charge'] > 0)
                                                        <br><span class="badge badge-primary">Pro</span></br>
                                                    @endif
                                                </h6>
                                                <time datetime="{{$video['published_at']}}">{{duration_humans($video['duration'])}}</time>
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

    @include('components.frontend.comment', ['submitUrl' => route('ajax.course.comment', $course), 'comments' => $comments, 'users' => $commentUsers])

@endsection