@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '视频'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.video.create') }}" class="btn btn-primary ml-auto">添加</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="get">
                <div class="form-group">
                    <label>视频标题</label>
                    <input type="text" class="form-control" name="keywords" value="{{ request()->input('keywords', '') }}" placeholder="请输入关键字">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">过滤</button>
                    <a href="{{ route('backend.video.index') }}" class="btn btn-warning">重置</a>
                </div>
            </form>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>课程</th>
                    <th>视频</th>
                    <th>价格</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($videos as $video)
                    <tr>
                        <td>{{$video->id}}</td>
                        <td>{{$video->course->title}}</td>
                        <td>{{$video->title}}</td>
                        <td><span class="badge badge-info">{{$video->charge}}</span></td>
                        <td>{{$video->created_at}}</td>
                        <td>
                            <a href="{{route('backend.video.edit', $video)}}" class="btn btn-warning btn-sm">编辑</a>
                            @include('components.backend.destroy', ['url' => route('backend.video.destroy', $video)])
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

        <div class="col-sm-12">
            {{$videos->render()}}
        </div>
    </div>

@endsection