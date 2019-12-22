@extends('layouts.app')

@section('content')

    <div class="container-fluid bg-primary pt-60 pb-40">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12" style="padding-top: 160px;">
                    <h1 style="padding: 10px 20px; background-color: #fff; color: #4ed2c5; font-weight: 800;">
                        一切，从这里开始。</h1>
                    <p class="mt-4">
                        MeEdu 是基于 Laravel 开发的在线基于系统。使用它，你可以在几分钟之内搭建好完善的在线教育系统，它让你更加聚焦教学的开发！技术方面，它已经帮你做好啦！
                    </p>
                    <p class="mt-4">
                        <a href="{{route('courses')}}" class="btn btn-lg btn-danger">全部课程</a>
                    </p>
                </div>

                <div class="col-md-8 col-sm-12">
                    <img src="/images/index-banner-img.svg">
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-40 pb-40">
        <div class="row">
            <div class="col-sm-12">
                <div class="divider"><a class="fs-24" href="#">最新课程</a></div>
            </div>
            <div class="col-sm-12">
                <div class="card-deck">
                    @foreach($gLatestCourses as $index => $course)
                        @if($index > 2)
                            @break
                        @endif
                        <div class="col-sm-4">
                            <div class="card hover-shadow-2">
                                <img class="card-img-top" src="{{ image_url($course['thumb']) }}"
                                     alt="{{$course['title']}}">
                                <div class="card-body">
                                    <h4 class="card-title b-0 px-0">
                                        <a href="{{ route('course.show', [$course['id'], $course['slug']]) }}">{{$course['title']}}</a>
                                    </h4>
                                    <p>
                                        <small>最后更新：{{$course['updated_at']}}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-40 pb-40 bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="divider"><span class="fs-24">评价</span></div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-inverse" style="background-color: #3b5998">
                        <div class="card-header no-border">
                            <h5 class="card-title card-title-bold">小滕</h5>
                        </div>
                        <blockquote class="blockquote blockquote-inverse no-border card-body m-0">
                            <p>MeEdu 非常棒，我在几分钟之内就搭建好了自己的知识付费应用，感谢 MeEdu </p>
                            <div class="flexbox">
                                <time class="text-white" datetime="2017-10-02 20:00">2019/3/31</time>
                            </div>
                        </blockquote>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card card-inverse" style="background-color: #3b5998">
                        <div class="card-header no-border">
                            <h5 class="card-title card-title-bold">小滕</h5>
                        </div>
                        <blockquote class="blockquote blockquote-inverse no-border card-body m-0">
                            <p>MeEdu 非常棒，我在几分钟之内就搭建好了自己的知识付费应用，感谢 MeEdu </p>
                            <div class="flexbox">
                                <time class="text-white" datetime="2017-10-02 20:00">2019/3/31</time>
                            </div>
                        </blockquote>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card card-inverse" style="background-color: #3b5998">
                        <div class="card-header no-border">
                            <h5 class="card-title card-title-bold">小滕</h5>
                        </div>
                        <blockquote class="blockquote blockquote-inverse no-border card-body m-0">
                            <p>MeEdu 非常棒，我在几分钟之内就搭建好了自己的知识付费应用，感谢 MeEdu </p>
                            <div class="flexbox">
                                <time class="text-white" datetime="2017-10-02 20:00">2019/3/31</time>
                            </div>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-70 pb-40">
        <div class="row justify-content-center">
            @foreach($gRoles as $index => $role)
                <div class="col-lg-4">
                    <div class="card hover-shadow-2">
                        <div class="card-body text-center">
                            <h5 class="text-uppercase text-muted">{{$role['name']}}</h5>
                            <br>
                            <h3 class="price">
                                <sup>￥</sup>{{$role['charge']}}
                                <span>&nbsp;</span>
                            </h3>
                            <hr>
                            @foreach(explode("\n", $role['description']) as $row)
                                <p>{{$row}}</p>
                            @endforeach
                            <br><br>
                            <a class="btn btn-bold btn-block btn-primary" href="{{route('role.index')}}">立即订阅</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($links)
        <div class="container pt-40 pb-40">
            <div class="row">
                <div class="col-sm-12">
                    <h5>友情链接</h5>
                    @foreach($links as $link)
                        <a href="{{$link['url']}}" target="_blank"
                           style="margin-right: 2px; margin-bottom: 2px;">{{$link['name']}}</a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection