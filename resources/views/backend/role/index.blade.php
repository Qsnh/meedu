@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => 'VIP会员'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.role.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>权重</th>
                    <th>角色名</th>
                    <th>价格</th>
                    <th>时长</th>
                    <th>编辑时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->weight}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->charge}}</td>
                    <td>{{$role->expire_days}}</td>
                    <td>{{$role->updated_at}}</td>
                    <td>
                        <a href="{{route('backend.role.edit', $role)}}" class="btn btn-warning btn-sm">编辑</a>
                        @include('components.backend.destroy', ['url' => route('backend.role.destroy', $role)])
                    </td>
                </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="7">暂无记录</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <el-row>
        <el-col :span="24">
            <meedu-a :url="''" :name="'添加'"></meedu-a>
        </el-col>

@endsection