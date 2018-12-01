@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '管理员列表'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>姓名</th>
                    <th>邮箱</th>
                    <th>最后登录</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($administrators as $administrator)
                <tr>
                    <td>{{$administrator->name}}</td>
                    <td>{{$administrator->email}}</td>
                    <td>
                        <span class="badge badge-warning">{{$administrator->last_login_date}}</span>
                        <span class="badge badge-info">{{$administrator->last_login_ip}}</span>
                    </td>
                    <td>{{$administrator->created_at}}</td>
                    <td>
                        <a href="{{route('backend.administrator.edit', $administrator)}}" class="btn btn-warning btn-sm">编辑</a>
                        @include('components.backend.destroy', ['url' => route('backend.administrator.destroy', $administrator)])
                    </td>
                </tr>
                    @empty
                <tr>
                    <td colspan="5" class="text-center">暂无记录</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
            {{$administrators->render()}}
        </div>
    </div>

@endsection