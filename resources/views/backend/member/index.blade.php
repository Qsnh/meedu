@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '会员列表'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <form action="" method="get">
                <div class="form-group">
                    <label>呢称/手机号</label>
                    <input type="text" class="form-control" name="keywords" value="{{ request()->input('keywords', '') }}" placeholder="请输入关键字">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">过滤</button>
                    <a href="{{ route('backend.member.index') }}" class="btn btn-warning">重置</a>
                </div>
            </form>
        </div>

        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>头像</th>
                    <th>ID</th>
                    <th>手机号</th>
                    <th>昵称</th>
                    <th>是否激活</th>
                    <th>是否锁定</th>
                    <th>注册时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($members as $member)
                <tr>
                    <td><img src="{{$member->avatar}}" class="avatar" width="50" height="50"></td>
                    <td>{{$member->id}}</td>
                    <td>{{$member->mobile}}</td>
                    <td>{{$member->nick_name}}</td>
                    <td>{{$member->is_active == 1 ? '是' : '否'}}</td>
                    <td>{{$member->is_lock == 1 ? '是' : '否'}}</td>
                    <td>{{$member->created_at}}</td>
                    <td>
                        <a href="{{route('backend.member.show', $member)}}" class="btn btn-warning btn-sm">详情</a>
                    </td>
                </tr>
                    @empty
                <tr>
                    <td class="text-center" colspan="8">暂无记录</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
            {{$members->render()}}
        </div>
    </div>

@endsection