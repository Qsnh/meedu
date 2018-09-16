@extends('layouts.member')

@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            <td>开始时间</td>
            <td>结束时间</td>
            <td>价格</td>
            <td>会员</td>
        </tr>
        </thead>
        <tbody>
        @forelse($records as $record)
        <tr>
            <td>{{$record->started_at}}</td>
            <td>{{$record->expired_at}}</td>
            <td><span class="label label-default">￥{{$record->charge}}</span></td>
            <td>{{$record->role->name}}</td>
        </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="4">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection