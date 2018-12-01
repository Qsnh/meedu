@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '公告'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.announcement.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>添加人</th>
                    <th>最后编辑时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($announcements as $announcement)
                <tr>
                    <td>{{$announcement->administrator->name}}</td>
                    <td>{{$announcement->updated_at}}</td>
                    <td>
                        <a href="{{route('backend.announcement.edit', $announcement)}}" class="btn btn-warning btn-sm">编辑</a>
                        @include('components.backend.destroy', ['url' => route('backend.announcement.destroy', $announcement)])
                    </td>
                </tr>
                    @empty
                <tr>
                    <td class="text-center" colspan="3">暂无数据</td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-sm-12">
            {{$announcements->render()}}
        </div>
    </div>

@endsection