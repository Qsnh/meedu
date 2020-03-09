@extends('layouts.h5')

@section('content')

    <div class="container-fluid bg-fff mb-5">
        <div class="row">
            <div class="col-12">
                <h3 class="my-3">全部课程</h3>
            </div>
            <div class="col-12">
                <div class="course-list-box">
                    @foreach($courses as $course)
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {!! str_replace('pagination', 'pagination justify-content-center', $courses->render()) !!}
            </div>
        </div>
    </div>

    @include('h5.components.navbar')

@endsection