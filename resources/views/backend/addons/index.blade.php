@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '插件'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                <tr>
                    <th>插件</th>
                    <th>基础信息</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($addons as $item)
                    <tr>
                        <td>
                            <p><img src="{{$item->thumb}}" width="60" height="60" class="img-thumbnail"></p>
                            <p>{{$item->name}}</p>
                            <p>作者：<author>{{$item->name}}</author></p>
                        </td>
                        <td>
                            <p>版本：{{$item->currentVersion ? $item->currentVersion->version : '暂无'}}</p>
                            <p>路径：<code>{{$item->path}}</code></p>
                            <p>时间：{{$item->created_at}}</p>
                        </td>
                        <td>
                            <a href="{{route('backend.addons.logs', $item)}}" class="btn btn-secondary">日志</a>
                            <a href="{{route('backend.addons.versions', $item)}}" class="btn btn-info">历史版本</a>
                            @if($item->prev_version_id)
                            <a href="{{route('backend.addons.version.switch', [$item->id, $item->prev_version_id])}}"
                               onclick="return confirm('确定执行回滚操作？')" class="btn btn-warning">回滚最近一次的安装</a>
                            @endif
                            <a href="{{route('backend.addons.dependencies.install', $item)}}"
                               onclick="return confirm('确定执行此操作？')" class="btn btn-primary">提交依赖安装任务</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection