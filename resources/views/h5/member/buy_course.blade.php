@extends('layouts.h5')

@section('content')

    <div class="top-navbar">
        <a href="{{route('member')}}" class="back">返回</a>
        <span class="title">我的课程</span>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 course-list-box">
                @forelse($records as $index => $record)
                    @if(!($course = $courses[$record['course_id']] ?? []))
                        @continue
                    @endif
                    <a href="{{route('course.show', [$course['id'], $course['slug']])}}"
                       class="course-list-item d-flex">
                        <div class="course-thumb">
                            <img src="{{$course['thumb']}}"
                                 width="122"
                                 height="70">
                        </div>
                        <div class="course-info-box w-100">
                            <div class="course-title">{{$course['title']}}</div>
                            <div class="course-info">
                                <span>课时：{{$course['videos_count']}}节</span>
                                <span class="price">{{$course['charge'] > 0 ? '￥' . $course['charge'] : '免费'}}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    @include('h5.components.none')
                @endforelse
            </div>

            @if($records->total() > $records->perPage())
                <div class="col-12">
                    {!! str_replace('pagination', 'pagination justify-content-center', $records->render()) !!}
                </div>
            @endif
        </div>
    </div>

@endsection