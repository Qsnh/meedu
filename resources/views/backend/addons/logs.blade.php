@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '插件'])

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{route('backend.addons.index')}}" class="btn btn-primary ml-auto btn-sm">返回插件列表</a>
        </div>
        <div class="col-sm-12">
            <h3>{{$addons->name}}的安装日志</h3>
            @foreach($logs as $log)

                <div class="card">
                    <div class="card-header">
                        {{$log->version}} | {{$log->type}} | {{$log->created_at}}
                    </div>
                    <div class="card-body">
                        <pre>{{$log->log}}</pre>
                    </div>
                </div>

                @endforeach
        </div>
    </div>

@endsection