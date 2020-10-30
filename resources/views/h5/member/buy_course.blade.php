@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '我的课程', 'back' => route('member')])

    <div class="nav-menus">
        <a class="menu-item {{!$scene ? 'active' : ''}}"
           href="{{route('member.courses')}}?{{$queryParams(['scene' => ''])}}">已购课程</a>
        <a class="menu-item {{$scene === 'videos' ? 'active' : ''}}"
           href="{{route('member.courses')}}?{{$queryParams(['scene' => 'videos'])}}">已购视频</a>
        <a class="menu-item {{$scene === 'like' ? 'active' : ''}}"
           href="{{route('member.courses')}}?{{$queryParams(['scene' => 'like'])}}">我的收藏</a>
        <a class="menu-item {{$scene === 'history' ? 'active' : ''}}"
           href="{{route('member.courses')}}?{{$queryParams(['scene' => 'history'])}}">历史学习</a>
    </div>

    <div class="member-courses-page">
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
                {!! str_replace('pagination', 'pagination justify-content-center', $records->render('pagination::simple-bootstrap-4')) !!}
            @endif
        </div>
    </div>

@endsection