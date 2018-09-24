@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '会员详情'])

    <el-row>
        <el-col :span="24" style="margin-bottom: 20px;">
            <meedu-a :url="'{{ route('backend.member.index') }}'" :name="'返回列表'"></meedu-a>
        </el-col>
    </el-row>

    <el-row>
        <el-col span="6" class="member-detail-left">
            <ul class="text-center">
                <li class="avatar"><img src="{{$member->avatar}}" width="60" height="60"></li>
                <li>昵称：{{$member->nick_name}}</li>
                <li>手机号：{{$member->mobile}}</li>
                <li>注册时间：{{$member->created_at}}</li>
                <li>账户余额：{{$member->credit1}}</li>
                @if($member->role)
                    <li>VIP：{{$member->role->name}}</li>
                    <li>到期时间：{{$member->role_expired_at}}</li>
                @endif
            </ul>
        </el-col>
        <el-col span="18" class="member-detail-right">
            <el-collapse v-model="activeNames" @change="handleChange">
                <el-collapse-item title="消费记录" name="1">
                    <table>
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
                                <td>{{ $order->getGoodsTypeText() }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="3">暂无数据</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </el-collapse-item>
                <el-collapse-item title="充值记录" name="2">
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
                </el-collapse-item>
                <el-collapse-item title="已购课程" name="3">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td>课程</td>
                            <td>价格</td>
                            <td>时间</td>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($user->joinCourses as $course)
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
                </el-collapse-item>
                <el-collapse-item title="已购视频" name="4">
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
                </el-collapse-item>
                <el-collapse-item title="订阅记录" name="5">
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
                </el-collapse-item>
            </el-collapse>
        </el-col>
    </el-row>

@endsection

@section('js')
    <script>
        new Vue({
            el: '#app',
            data: function () {
                return {
                    activeNames: ['1']
                }
            },
            methods: {
                handleChange: function(val) {
                    console.log(val);
                }
            }
        });
    </script>
@endsection