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

            <div class="col-sm-12">
                <h2 class="text-center index-banner-title">最新课程</h2>
            </div>

            @foreach($courses as $course)
                <div class="col-sm-4">
                    <div class="card mt-15 mb-15">
                        <img class="card-img-top" style="height: 300px;" data-echo="{{ image_url($course->thumb) }}" src="/images/loading.png">
                        <div class="card-body">
                            <h5 class="card-title">{{$course->title}}</h5>
                            <p class="card-text">{{$course->short_description}}</p>
                            <a href="{{ route('course.show', [$course->id, $course->slug]) }}" class="btn btn-primary">详情</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <div class="container-fluid roles">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12">
                            <h2 class="text-center index-banner-title">计划</h2>
                        </div>

                        @foreach($roles as $role)
                            <div class="col-sm-4 roles-item">
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
                        <div class="col-sm-6">
                            <h3 class="text-center">订阅本站获取最新消息</h3>
                            <form action="{{route('subscription.email')}}" method="post">
                                @csrf
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control" placeholder="请输入邮箱" required>
                                    <div class="input-group-append">
                                        <button type="submit" style="width: 100px;" class="btn btn-primary">订阅</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!$links->isEmpty())
    <div class="container-fluid index-links">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h5>友情链接</h5>
                        @foreach($links as $link)
                            <a href="{{$link->url}}" target="_blank">{{$link->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection