@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '我的课程', 'back' => route('index'), 'class' => 'primary'])

    <div class="courses-menu">
        <div class="menu-item {{!$scene ? 'active' : ''}}">
            <a href="{{route('member.courses')}}?{{$queryParams(['scene' => ''])}}">订阅课程</a>
        </div>
        <div class="menu-item {{$scene === 'videos' ? 'active' : ''}}">
            <a href="{{route('member.courses')}}?{{$queryParams(['scene' => 'videos'])}}">已购视频</a>
        </div>
        <div class="menu-item {{$scene === 'history' ? 'active' : ''}}">
            <a href="{{route('member.courses')}}?{{$queryParams(['scene' => 'history'])}}">历史学习</a>
        </div>
    </div>

    @if($scene !== 'videos')
        <div class="box">
            <div class="courses">
                @forelse($records as $index => $record)
                    @if(!($course = $courses[$record['course_id']] ?? []))
                        @continue
                    @endif
                    @include('h5.components.course', ['course' => $course])
                @empty
                    @include('h5.components.none')
                @endforelse
            </div>
        </div>

    @else

        <div class="videos">
            @forelse($records as $courseId => $record)
                @if(!($course = $courses[$courseId] ?? []))
                    @continue
                @endif
                <div class="course-title">{{$course['title']}}</div>
                <div class="videos-box">
                    @foreach($record as $video)
                        <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                           class="video-item">{{$video['title']}}</a>
                    @endforeach
                </div>
            @empty
                @include('h5.components.none')
            @endforelse
        </div>

    @endif

    <div class="box">
        @if($records->total() > $records->perPage())
            <div class="col-12">
                {!! str_replace('pagination', 'pagination justify-content-center', $records->render()) !!}
            </div>
        @endif
    </div>

@endsection