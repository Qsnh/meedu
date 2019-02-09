@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '云插件'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <table class="table">
                <thead>
                <tr>
                    <th>封面</th>
                    <th>插件</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($addons as $item)
                    <tr>
                        <td>
                            <img src="{{$item['thumb']}}" width="120" height="60" class="img-thumbnail">
                        </td>
                        <td>
                            <p><span class="badge badge-info">{{$item['name']}}</span></p>
                            <p><span class="badge badge-info">{{$item['sign']}}</span></p>
                            <p><span class="badge badge-info">{{$item['version']}}</span></p>
                        </td>
                        <td>
                            {{$item['installed'] ? '已安装' : '未安装'}}
                        </td>
                        <td>
                            <a href="" class="btn btn-info">安装</a>
                            <a href="" class="btn btn-info">卸载</a>
                            <a href="" class="btn btn-info">升级</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection