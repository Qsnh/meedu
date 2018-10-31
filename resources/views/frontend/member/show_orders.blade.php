@extends('layouts.member')

@section('member')

    <div class="row">
        <h3>我的订单</h3>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <td>价格</td>
            <td>商品</td>
            <td>时间</td>
            <td>状态</td>
        </tr>
        </thead>
        <tbody>
        @forelse($orders as $order)
            <tr>
                <td><span class="badge badge-danger">￥{{ $order->charge }}</span></td>
                <td>{{ $order->getOrderListTitle() }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    @if($order->status == 9)
                        <span class="badge badge-success">已支付</span>
                        @else
                        <span class="badge badge-info">未支付</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="4">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-right">
        {{$orders->render()}}
    </div>
@endsection