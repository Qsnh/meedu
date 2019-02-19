@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '插件'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{route('backend.addons.index')}}" class="btn btn-primary ml-auto btn-sm">返回插件列表</a>
        </div>
        <div class="col-sm-12">
            <h3>{{$addons->name}}的历史版本</h3>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>版本</th>
                        <th>路径</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($versions as $index => $version)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>
                            {{$version->version}}
                            @if($version->id == $addons->current_version_id)
                                <span class="badge badge-warning">使用版本</span>
                                @endif
                            @if($version->id == $addons->prev_version_id)
                                <span class="badge badge-secondary">上一个版本</span>
                            @endif
                        </td>
                        <td><code>{{$version->path}}</code></td>
                        <td>
                            @if($version->id != $addons->current_version_id)
                            <a href="{{route('backend.addons.version.switch', [$version->addons_id, $version->id])}}"
                               onclick="return confirm('确定操作？')" class="btn btn-primary btn-sm">切换到这个版本</a>
                                @else
                                无
                            @endif
                        </td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>

@endsection