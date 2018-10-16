@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm index-banner text-center">
                <h1>书山有路勤为径，学海无涯苦作舟</h1>
                <h4>你想要的，这里都有！</h4>
                <p class="button">
                    <a href="{{ route('courses') }}">立即订阅</a>
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row index-banner2">

            <div class="col-sm-12 text-center index-banner-title">
                <h3>最新课程</h3>
            </div>

            @foreach($courses as $course)
                <div class="col-sm course text-center">
                    <a href="{{ route('course.show', [$course->id, $course->slug]) }}">
                        <div class="course-item border">
                            <div class="thumb">
                                <img data-echo="{{ image_url($course->thumb) }}" src="/images/loading.png" width="100%" height="300">
                            </div>
                            <div class="title">{{ $course->title }}</div>
                        </div>
                    </a>
                </div>
            @endforeach

        </div>
    </div>

    <div class="container-fluid roles">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h3 class="title">计划</h3>
                        </div>

                        @foreach($roles as $role)
                            <div class="col-sm roles-item">
                                <div class="roles-item-info text-center border">
                                    <h2 class="title">{{$role->name}}</h2>
                                    @foreach($role->descriptionRows() as $row)
                                        <p>{{$row}}</p>
                                    @endforeach
                                    <p class="price">￥{{$role->charge}}</p>
                                    <p>
                                        <a href="{{route('role.index')}}" class="buy-button">立即订阅</a>
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid index-subscription">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-8">
                            <h3 class="text-center">订阅本站获取最新消息</h3>
                            <form action="{{route('subscription.email')}}" method="post">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="input-subscription" placeholder="请输入邮箱" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn-subscription">订阅</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection