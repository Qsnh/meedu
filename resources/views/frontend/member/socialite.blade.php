@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">快捷登录</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="text-center">
                            <tr>
                                <td>应用</td>
                                <td>绑定时间</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($apps as $app)
                                <tr class="text-center">
                                    <td>{{$app['app']}}</td>
                                    <td>{{$app['created_at']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center color-gray" colspan="2">暂无数据</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection