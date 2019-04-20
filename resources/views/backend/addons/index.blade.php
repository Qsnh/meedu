@extends('layouts.backend')

@section('title')
    插件
    @endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12 mb-3">
            <a href="{{route('backend.addons.generateAutoloadFile')}}" class="btn btn-primary">GenerateMap</a>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>作者</th>
                    <th>插件</th>
                    <th>版本</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($addons as $item)
                    <tr>
                        <td><img src="{{$item->thumb}}" width="30" height="30" class="img-thumbnail"></td>
                        <td><author>{{$item->author}}</author></td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->currentVersion ? $item->currentVersion->version : '暂无'}}</td>
                        <td>{{$item->getStatusText()}}</td>
                        <td>
                            <a href="{{route('backend.addons.versions', $item)}}" class="btn btn-info">历史版本</a>
                            @if($item->main_url)
                            <a class="btn btn-primary" href="{{$item->main_url}}">主页</a>
                            @endif
                            <a onclick="return confirm('确定删除？')"
                               href="{{route('backend.addons.uninstall', $item)}}" class="btn btn-danger">卸载</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            暂无插件，前去挑选 <a href="https://meedu.vip" target="_blank">应用商店</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection