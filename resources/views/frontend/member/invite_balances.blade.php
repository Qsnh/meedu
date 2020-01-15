@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">

            </div>
            <div class="col-12 py-4">
                邀请余额记录，共{{$balanceRecords->total()}}条记录
            </div>
            <div class="col-12">
                <div class="w-100 float-left bg-fff px-3 pt-5 br-8 mb-4">
                    <table class="table">
                        <thead class="text-center">
                        <tr>
                            <th>金额</th>
                            <th>说明</th>
                            <th>时间</th>
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

            @if($balanceRecords->total() > $balanceRecords->perPage())
                <div class="col-md-12">
                    <div class="w-100 float-left bg-fff mb-4 br-8 px-3 py-4">
                        {{$balanceRecords->render()}}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection