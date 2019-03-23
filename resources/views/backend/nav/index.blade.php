@extends('layouts.backend')

@section('title')
    首页导航
@endsection

@section('body')

<div class="row row-cards">
    <div class="col-sm-12">
        <a href="{{ route('backend.nav.create') }}" class="btn btn-primary ml-auto">添加</a>
    </div>
    <div class="col-sm-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>排序值</th>
                <th>链接名</th>
                <th>链接地址</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse($rows as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->sort}}</td>
<td>{{$row->name}}</td>
<td>{{$row->url}}</td>
                <td>
                    <a href="{{route('backend.nav.edit', $row)}}" class="btn btn-warning btn-sm">编辑</a>
                    @include('components.backend.destroy', ['url' => route('backend.nav.destroy', $row)])
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
    <div class="col-sm-12">
        {{$rows->render()}}
    </div>
</div>

@endsection