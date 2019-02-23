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
                @forelse($addons as $item)
                    <tr>
                        <td>
                            <p><img src="{{$item->thumb}}" width="60" height="60" class="img-thumbnail"></p>
                            <p>{{$item->name}}</p>
                            <p>作者：<author>{{$item->author}}</author></p>
                        </td>
                        <td>
                            <p>版本：{{$item->currentVersion ? $item->currentVersion->version : '暂无'}}</p>
                            <p>路径：<code>{{$item->path}}</code></p>
                            <p>时间：{{$item->created_at}}</p>
                        </td>
                        <td>
                            <a href="{{route('backend.addons.logs', $item)}}" class="btn btn-secondary">日志</a>
                            <a href="{{route('backend.addons.versions', $item)}}" class="btn btn-info">历史版本</a>
                            <a href="{{route('backend.addons.dependencies.install', $item)}}"
                               onclick="return confirm('确定执行此操作？')" class="btn btn-primary">提交依赖安装任务</a>
                            @if($item->main_url)
                            <a class="btn btn-primary" href="{{$item->main_url}}">主页</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            暂无插件，前去挑选 <a href="https://meedu.vip" target="_blank">应用商店</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection