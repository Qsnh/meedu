@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '友情链接'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.link.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>排序</th>
                    <th>链接名</th>
                    <th>链接地址</th>
                    <th>添加时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($links as $link)
                <tr>
                    <td>{{$link->id}}</td>
                    <td>{{$link->sort}}</td>
                    <td>{{$link->name}}</td>
                    <td>{{$link->url}}</td>
                    <td>{{$link->created_at}}</td>
                    <td>
                        <a href="{{route('backend.link.edit', $link)}}" class="btn btn-warning btn-sm">编辑</a>
                        @include('components.backend.destroy', ['url' => route('backend.link.destroy', $link)])
                    </td>
                </tr>
                    @empty
                <tr>
                    <td class="text-center" colspan="6">暂无记录</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection