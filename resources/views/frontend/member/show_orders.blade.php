@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12 py-4">
                共{{$orders->total()}}条记录
            </div>
            <div class="col-12 mb-4">
                <div class="w-100 float-left bg-fff px-3 pt-5 br-8">
                    <table class="table">
                        <thead class="text-center">
                        <tr>
                            <th>支付方式</th>
                            <th>价格</th>
                            <th>商品</th>
                            <th>时间</th>
                            <th>状态</th>
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
                                    <span class="badge badge-default">{{$order['status_text']}}</span>
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

            @if($orders->total() > $orders->perPage())
                <div class="col-md-12">
                    <div class="w-100 float-left bg-fff mb-4 br-8 px-3 py-4">
                        {{$orders->render()}}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection