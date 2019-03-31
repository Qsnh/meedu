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

    <div class="container">
        <div class="row">
            @foreach($courses as $course)
                <div class="col-sm-4">
                    <div class="card mt-15 mb-15">
                        <img class="card-img-top" style="height: 300px;" data-echo="{{ image_url($course->thumb) }}" src="/images/loading.png">
                        <div class="card-body">
                            <h5 class="card-title">
                                @if($course->charge > 0)
                                    <span class="badge badge-danger">￥{{$course->charge}}</span>
                                    @else
                                    <span class="badge badge-success">免费</span>
                                @endif
                                {{$course->title}}
                            </h5>
                            <p class="card-text">{{$course->short_description}}</p>
                            <a href="{{ route('course.show', [$course->id, $course->slug]) }}" class="btn btn-primary">详情</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="Page navigation">
                    {{$courses->render()}}
                </nav>
            </div>
        </div>

    </div>

@endsection