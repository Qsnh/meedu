@extends('layouts.member')

@section('member')

    <table class="table table-hover">
        <thead>
        <tr>
            <td>价格</td>
            <td>类型</td>
            <td>时间</td>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td>
                    @if($order->charge == 0)
                        <span class="label label-success">￥0</span>
                        @else
                        <span class="label label-danger">￥{{ $order->charge }}</span>
                    @endif
                </td>
                <td>{{ $order->getGoodsTypeText() }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="3">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-right">
        {{$orders->render()}}
    </div>
@endsection