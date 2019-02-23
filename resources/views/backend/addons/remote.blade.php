@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '云插件'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                <tr>
                    <th class="text-center" width="80">封面</th>
                    <th width="200">插件</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($addons as $item)
                    <tr>
                        <td>
                            <img src="{{$item['thumb']}}" width="60" height="60" class="img-thumbnail">
                        </td>
                        <td>
                            <span class="badge badge-info">{{$item['name']}}</span><br>
                            <span class="badge badge-info">最新版本：{{$item['version']}}</span>
                        </td>
                        <td>
                            {{$item['installed'] ? '已安装' : '未安装'}}
                        </td>
                        <td>
                            @if($item['installed'])
                                @if($item['upgrade'])
                                    <a href="{{route('backend.addons.remote.upgrade', ['sign' => $item['sign'], 'version' => $item['version']])}}"
                                       class="btn btn-info">升级</a>
                                @endif
                            @else
                                <a href="{{route('backend.addons.remote.install', ['sign' => $item['sign'], 'version' => $item['version']])}}"
                                   class="btn btn-info">安装</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            暂无插件，前去挑选 <a href="https://meedu.vip" target="_blank">应用商店</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection