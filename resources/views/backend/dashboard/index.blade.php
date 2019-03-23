@extends('layouts.backend_other')

@section('title')
    主面板
@endsection

@section('body')

    <div class="row row-cards">

        <div class="col-6 col-lg-4">
            <div class="card card-body text-center bg-primary">
                <div class="fs-40 fw-100">+{{$todayRegisterUserCount}}</div>
                <div>今日注册</div>
            </div>
        </div>

        <div class="col-6 col-lg-4">
            <div class="card card-body text-center bg-info">
                <div class="fs-40 fw-100">￥{{$todayPaidSum}}</div>
                <div>今日收入</div>
            </div>
        </div>

        <div class="col-6 col-lg-4">
            <div class="card card-body text-center bg-danger">
                <div class="fs-40 fw-100">+{{$todayPaidNum}}</div>
                <div>今日订单</div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <h4 class="card-title"><strong>如何快速创建一门课程？</strong></h4>

                <div class="card-body">
                    <div data-provide="wizard" data-navigateable="true">
                        <ul class="nav nav-process nav-process-circle">
                            <li class="nav-item">
                                <span class="nav-title">第一步</span>
                                <a class="nav-link" data-toggle="tab" href="#wizard-navable-1"></a>
                            </li>

                            <li class="nav-item">
                                <span class="nav-title">第二步</span>
                                <a class="nav-link" data-toggle="tab" href="#wizard-navable-2"></a>
                            </li>

                            <li class="nav-item">
                                <span class="nav-title">第三步</span>
                                <a class="nav-link" data-toggle="tab" href="#wizard-navable-3"></a>
                            </li>

                            <li class="nav-item">
                                <span class="nav-title">第四步</span>
                                <a class="nav-link" data-toggle="tab" href="#wizard-navable-4"></a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane text-center fade active show" id="wizard-navable-1">
                                <p class="my-2">
                                    首先，您需要创建一门课程，<a href="{{route('backend.course.create')}}">点我创建</a>
                                </p>
                            </div>

                            <div class="tab-pane text-center fade" id="wizard-navable-2">
                                <p class="my-2">
                                    在课程创建完成之后，您还需要在该课程下上传视频，<a href="{{route('backend.video.create')}}">点我创建</a>
                                </p>
                            </div>

                            <div class="tab-pane text-center fade" id="wizard-navable-3">
                                <p class="my-2">
                                    如果视频上传失败，可能是您没有配置视频相关服务，<a href="{{route('backend.setting.index')}}">前去配置</a>
                                </p>
                            </div>

                            <div class="tab-pane text-center fade" id="wizard-navable-4">
                                <p class="my-2">
                                    到此，您的课程已创建完毕，去首页看看吧 <a target="_blank" href="{{url('/')}}">首页</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection