@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '角色列表'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.administrator_role.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>角色名</th>
                    <th>Slug</th>
                    <th>描述</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>{{$role->display_name}}</td>
                    <td>{{$role->slug}}</td>
                    <td>{{$role->description}}</td>
                    <td>{{$role->created_at}}</td>
                    <td>
                        <a href="{{route('backend.administrator_role.edit', $role)}}" class="btn btn-warning btn-sm">编辑</a>
                        @include('components.backend.destroy', ['url' => route('backend.administrator_role.destroy', $role)])
                        <a href="{{route('backend.administrator_role.permission', $role)}}" class="btn btn-info btn-sm">授权</a>
                    </td>
                </tr>
                    @empty
                <tr>
                    <td class="text-center" colspan="5">暂无记录</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection