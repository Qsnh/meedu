@extends('layouts.backend')

@section('title')
    插件
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12 mb-3">
            <a href="{{route('backend.addons.generateProvidersMap')}}" class="btn btn-primary">插件安装之后点我一次</a>
            <a href="https://meedu.vip" class="btn btn-primary" target="_blank">应用商店</a>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>作者</th>
                    <th>版本</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($addons as $item)
                    <tr>
                        <td>{{$item['name'] ?? ''}}</td>
                        <td><author>{{$item['author'] ?? ''}}</author></td>
                        <td>{{$item['version'] ?? ''}}</td>
                        <td>
                            @if($item['main_url'] ?? '')
                                <a href="{{$item['main_url']}}" class="btn btn-primary">进入插件</a>
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