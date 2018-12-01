@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '会员详情'])

    <div class="row row-cards">
        <div class="col-sm-12 mb-3">
            <a href="{{ route('backend.member.index') }}" class="btn btn-primary ml-auto">返回列表</a>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <span>基础信息</span>
                </div>
                <div class="card-body">
                    <ul class="text-center list-group">
                        <li class="list-group-item"><img class="avatar" src="{{$member->avatar}}" width="60" height="60"></li>
                        <li class="list-group-item">昵称：{{$member->nick_name}}</li>
                        <li class="list-group-item">手机号：{{$member->mobile}}</li>
                        <li class="list-group-item">注册时间：{{$member->created_at}}</li>
                        <li class="list-group-item">账户余额：{{$member->credit1}}</li>
                        @if($member->role)
                            <li class="list-group-item">VIP：{{$member->role->name}}</li>
                            <li class="list-group-item">到期时间：{{$member->role_expired_at}}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <span>消费记录</span>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>时间</td>
                            <td>金额</td>
                            <td>状态</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($member->orders as $order)
                            <tr>
                                <td>￥{{ $order->charge }}</td>
                                <td>{{ $order->getOrderListTitle() }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="3">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">充值记录</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>时间</td>
                            <td>金额</td>
                            <td>状态</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($member->rechargePayments as $record)
                            <tr>
                                <td>{{$record->created_at}}</td>
                                <td><span class="label label-default">￥{{$record->money}}</span></td>
                                <td><span class="label label-success">成功</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="3">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">已购课程</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>课程</td>
                            <td>价格</td>
                            <td>时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($member->joinCourses as $course)
                            <tr>
                                <td><a href="{{ route('course.show', [$course->id, $course->slug]) }}">{{ $course->title }}</a></td>
                                <td>
                                    @if($course->pivot->charge > 0)
                                        <span class="label label-danger">{{ $course->pivot->charge }} 元</span>
                                    @else
                                        <span class="label label-success">免费</span>
                                    @endif
                                </td>
                                <td>{{$course->pivot->created_at}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="3">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">已购视频</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>课程</td>
                            <td>视频</td>
                            <td>价格</td>
                            <td>时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($member->buyVideos as $video)
                            <tr>
                                <td><a href="{{ route('course.show', [$video->course->id, $video->course->slug]) }}">{{ $video->course->title }}</a></td>
                                <td>
                                    <a href="{{ route('video.show', [$video->course->id, $video->id, $video->slug]) }}">{{$video->title}}</a>
                                </td>
                                <td>
                                    @if($video->pivot->charge > 0)
                                        <span class="label label-danger">{{ $video->pivot->charge }} 元</span>
                                    @else
                                        <span class="label label-success">免费</span>
                                    @endif
                                </td>
                                <td>{{$video->pivot->created_at}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="4">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">VIP记录</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>开始时间</td>
                            <td>结束时间</td>
                            <td>价格</td>
                            <td>会员</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($member->joinRoles as $record)
                            <tr>
                                <td>{{$record->started_at}}</td>
                                <td>{{$record->expired_at}}</td>
                                <td><span class="label label-default">￥{{$record->charge}}</span></td>
                                <td>{{$record->role->name}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="4">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    </table>
                </div>
            </div>

        </div>
    </div>

@endsection