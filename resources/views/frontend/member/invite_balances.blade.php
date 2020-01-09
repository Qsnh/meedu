@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        邀请余额变动记录
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="text-center">
                            <tr>
                                <td>金额</td>
                                <td>说明</td>
                                <td>时间</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($balanceRecords as $item)
                                <tr class="text-center">
                                    <td>￥{{$item['total']}}</td>
                                    <td>{{$item['desc']}}</td>
                                    <td>{{$item['created_at']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center color-gray" colspan="3">暂无数据</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-10">
                <div class="text-right">
                    {{$balanceRecords->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection