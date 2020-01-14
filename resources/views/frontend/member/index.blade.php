@extends('layouts.member')

@section('member')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 col-12 text-center mb-2">
                <div class="py-4 box-shadow1 br-8 bg-fff">
                    <span>我的课程</span><br><br>
                    <span class="fs-24px c-primary">{{$courseCount}}</span>
                </div>
            </div>
            <div class="col-md-3 col-12 text-center mb-2">
                <div class="py-4 box-shadow1 br-8 bg-fff">
                    <span>我的视频</span><br><br>
                    <span class="fs-24px c-primary">{{$videoCount}}</span>
                </div>
            </div>
            <div class="col-md-3 col-12 text-center mb-2">
                <div class="py-4 box-shadow1 br-8 bg-fff">
                    <span>会员类型</span><br><br>
                    <span class="fs-24px c-primary">
                        @if($user['role'])
                            {{$user['role']['name']}}
                        @else
                            免费会员
                        @endif
                    </span>
                </div>
            </div>
            <div class="col-md-3 col-12 text-center mb-2">
                <div class="py-4 box-shadow1 br-8 bg-fff">
                    <span>邀请余额</span><br><br>
                    <span class="fs-24px">
                        <a href="{{route('member.invite_balance_records')}}"
                           class="c-primary">￥{{$user['invite_balance']}}</a>
                        <a href="" class="fs-14px ml-3 c-primary">提现</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="fw-400 mb-4 c-primary">最新课程 <a href="{{route('videos')}}" class="fs-14px ml-2">全部课程</a>
                </h2>
                <div class="row">
                    @foreach($gLatestCourses as $index => $courseItem)
                        @if($index == 8)
                            @break
                        @endif
                        <div class="col-12 col-md-3 pb-24px video-item">
                            <a href="{{route('course.show', [$courseItem['id'], $courseItem['slug']])}}">
                                <div class="video-item-box box-shadow1 br-8 t1 float-left">
                                    <div class="video-thumb">
                                        <div class="video-thumb-img"
                                             style="background: url('{{$courseItem['thumb']}}') center center no-repeat;background-size: cover;">
                                        </div>
                                    </div>
                                    <div class="video-title py-3 float-left">
                                        <span>{{$courseItem['title']}}</span>
                                    </div>
                                    <div class="video-extra pb-3">
                                        <span class="float-left"><i class="fa fa-file-video-o"></i> {{$courseItem['videos_count']}}</span>
                                        <span class="float-right">
                                            @if($courseItem['category'])
                                                <i class="fa fa-tag"></i> {{$courseItem['category']['name']}}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection