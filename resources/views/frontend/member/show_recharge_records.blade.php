@extends('layouts.member')

@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            <td>时间</td>
            <td>金额</td>
            <td>状态</td>
        </tr>
        </thead>
        <tbody>
        @forelse($records as $record)
            <tr>
                <td>{{$record->created_at}}</td>
                <td><span class="label label-default">￥{{$record->money}}</span></td>
                <td><span class="label label-success">成功</span></td>
            </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="3">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-right">{{$records->render()}}</div>
@endsection