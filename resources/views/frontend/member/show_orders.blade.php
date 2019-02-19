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
            <td>操作</td>
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
                        <span class="badge badge-primary">未支付</span>
                    @endif
                </td>
                <td>
                    @if($order->status != 9)
                        <a href="{{route('order.show', $order->order_id)}}" class="btn btn-primary btn-sm">继续支付</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="5">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-right">
        {{$orders->render()}}
    </div>
@endsection