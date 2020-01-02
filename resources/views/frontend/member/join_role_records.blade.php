@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">我的视频</div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="text-center">
                            <tr>
                                <td>开始时间</td>
                                <td>结束时间</td>
                                <td>价格</td>
                                <td>会员</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($records as $record)
                                <tr class="text-center">
                                    <td>{{$record['started_at']}}</td>
                                    <td>{{$record['expired_at']}}</td>
                                    <td><span class="label label-default">￥{{$record['charge']}}</span></td>
                                    <td>{{$record['role']['name']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center color-gray" colspan="4">暂无数据</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-10">
                <div class="col-sm-12 pt-10">
                    <div class="text-right">
                        {{$records->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection