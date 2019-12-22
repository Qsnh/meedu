@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        我的订单
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="text-center">
                            <tr>
                                <td>支付方式</td>
                                <td>价格</td>
                                <td>商品</td>
                                <td>时间</td>
                                <td>状态</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($orders as $order)
                                <tr class="text-center">
                                    <td><span class="badge badge-secondary">{{$order['payment_text']}}</span></td>
                                    <td><span class="badge badge-success">￥{{ $order['charge'] }}</span></td>
                                    <td>{{ implode(',', array_column($order['goods'] ?? [], 'goods_text')) }}</td>
                                    <td>{{ $order['created_at'] }}</td>
                                    <td>
                                        @if($order['continue_pay'])
                                            <a href="{{route('order.show', [$order['order_id']])}}"
                                               class="btn btn-primary btn-sm">继续支付</a>
                                        @else
                                            <span class="badge badge-default">{{$order['status_text']}}</span>
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
                    </div>
                </div>
            </div>
            <div class="col-sm-12 mt-10">
                <div class="text-right">
                    {{$orders->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection