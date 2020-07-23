@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="course-menu-box">
                    <div class="menu-item {{!$scene ? 'active' : ''}}">
                        <a href="{{route('member.courses')}}?{{$queryParams(['scene' => ''])}}">订阅课程</a>
                    </div>
                    <div class="menu-item {{$scene === 'videos' ? 'active' : ''}}">
                        <a href="{{route('member.courses')}}?{{$queryParams(['scene' => 'videos'])}}">已购视频</a>
                    </div>
                    <div class="menu-item {{$scene === 'history' ? 'active' : ''}}">
                        <a href="{{route('member.courses')}}?{{$queryParams(['scene' => 'history'])}}">历史学习</a>
                    </div>
                    <div class="menu-item {{$scene === 'like' ? 'active' : ''}}">
                        <a href="{{route('member.courses')}}?{{$queryParams(['scene' => 'like'])}}">我的收藏</a>
                    </div>
                </div>
            </div>

            @if($scene !== 'videos')
                <div class="col-12">
                    <div class="my-courses course-list-box">
                        @forelse($records as $index => $record)
                            @if(!($course = $courses[$record['course_id']] ?? []))
                                @continue
                            @endif
                            @include('frontend.components.course-item', ['course' => $course, 'class' => (($index + 1) % 4 == 0) ? 'last' : ''])
                        @empty
                            @include('frontend.components.none')
                        @endforelse
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="my-videos">
                        @forelse($records as $courseId => $record)
                            @if(!($course = $courses[$courseId] ?? []))
                                @continue
                            @endif
                            <div class="my-videos-item">
                                <div class="course-title">
                                    {{$course['title']}}
                                    <a class="course-info-link"
                                       href="{{route('course.show', [$course['id'], $course['slug']])}}">完整课程</a>
                                </div>
                                @foreach($record as $video)
                                    <a href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}"
                                       class="video-item">
                                        <img class="player" src="{{asset('/images/icons/player.png')}}" width="24"
                                             height="24">
                                        <span class="video-title">{{$video['title']}}</span>
                                        <span class="duration">{{duration_humans($video['duration'])}}</span>
                                    </a>
                                @endforeach
                            </div>
                        @empty
                            @include('frontend.components.none')
                        @endforelse
                    </div>
                </div>
            @endif

            @if($records->total() > $records->perPage())
                <div class="col-12">
                    {!! str_replace('pagination', 'pagination justify-content-center', $records->render()) !!}
                </div>
            @endif
        </div>
    </div>

@endsection