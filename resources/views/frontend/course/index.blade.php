@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 course-index-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>全部课程</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container course-index-box">
        <div class="row">
            @foreach($courses as $course)
            <div class="col-sm-4 course-item">
                <a href="{{ route('course.show', ['id' => $course->id, 'slug' => $course->slug]) }}">
                    <div class="course-item-box border">
                        <p class="thumb">
                            <img data-echo="{{ image_url($course->thumb) }}" src="/images/loading.png" width="100%" height="300" alt="">
                        </p>
                        <p class="title">
                            {{$course->title}}
                        </p>
                        <p class="intro">
                            <span>最后更新时间 {{$course->created_at->diffForHumans()}}</span>
                        </p>
                    </div>
                </a>
            </div>
            @endforeach

            <div class="col-sm-12 text-center">
                {{$courses->render()}}
            </div>

        </div>
    </div>

@endsection