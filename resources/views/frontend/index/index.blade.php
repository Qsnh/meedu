@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 index-banner text-center">
                <h1>书山有路勤为径，学海无涯苦作舟</h1>
                <h4>这里，应有尽有！</h4>
                <p class="button">
                    <a href="">立即订阅</a>
                </p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">

            <div class="col-sm-12 index-banner2">
                <div class="text-center index-banner-title">
                    <h3>最新课程</h3>
                </div>
                <div class="row">
                    @foreach($courses as $course)
                        <a href="{{ route('course.show', [$course->id, $course->slug]) }}">
                            <div class="col-sm-4 course text-center">
                                <div class="course-item border">
                                    <div class="thumb">
                                        <img src="{{ $course->thumb }}" width="100%" height="300">
                                    </div>
                                    <div class="title">{{ $course->title }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid roles">
        <div class="row">
            <div class="col-sm-12">

                <div class="container">
                    <div class="col-sm-12 text-center">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="title">计划</h3>
                            </div>
                            <div class="col-sm-4 roles-item">
                                <div class="roles-item-info text-center border">
                                    <h2 class="title">半年会员</h2>
                                    <p>全部视频均可观看</p>
                                    <p>无次数限制</p>
                                    <p>专属小密圈</p>
                                    <p class="price">￥256</p>
                                    <p>
                                        <a href="" class="buy-button">立即订阅</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 roles-item">
                                <div class="roles-item-info active text-center border">
                                    <h2 class="title">年度会员</h2>
                                    <p>全部视频均可观看</p>
                                    <p>无次数限制</p>
                                    <p>专属小密圈</p>
                                    <p class="price">￥512</p>
                                    <p>
                                        <a href="" class="buy-button">立即订阅</a>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-4 roles-item">
                                <div class="roles-item-info text-center border">
                                    <h2 class="title">终身会员</h2>
                                    <p>全部视频均可观看</p>
                                    <p>无次数限制</p>
                                    <p>专属小密圈</p>
                                    <p class="price">￥2048</p>
                                    <p>
                                        <a href="" class="buy-button">立即订阅</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection