@extends('layouts.backend')

@section('body')

@include('components.breadcrumb', ['name' => '推广链接'])

<div class="row row-cards">
    <div class="col-sm-12">
        <a href="{{ route('backend.adfrom.create') }}" class="btn btn-primary ml-auto">添加</a>
    </div>
    <div class="col-sm-12">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>推广链接名</th>
                <th>推广链接特征值</th>
                <th>推广链接</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @forelse($rows as $row)
            <tr>
                <td>{{$row->id}}</td>
                <td>{{$row->from_name}}</td>
                <td>{{$row->from_key}}</td>
                <td>{{url('/')}}?from={{$row->from_key}}</td>
                <td>
                    <a href="{{route('backend.adfrom.edit', $row)}}" class="btn btn-warning btn-sm">编辑</a>
                    @include('components.backend.destroy', ['url' => route('backend.adfrom.destroy', $row)])
                    <a href="{{route('backend.adfrom.number', $row)}}" class="btn btn-info btn-sm">推广效果</a>
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="4">暂无记录</td>
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