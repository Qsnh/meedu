@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '我的订单', 'back' => route('member')])

    <div class="my-orders">
        @forelse($orders as $order)
            <div class="order-item">
                <div class="goods-title">{{ implode(',', array_column($order['goods'] ?? [], 'goods_text')) }}</div>
                <div class="goods">
                    <div class="goods-status">{{$order['status_text']}}</div>
                    <div class="goods-charge">￥{{ $order['charge'] }}</div>
                </div>
                <div class="info">
                    <div class="payment">{{$order['payment_text'] ?: '暂无'}}</div>
                    <div class="date">
                        {{ \Carbon\Carbon::parse($order['created_at'])->format('Y-m-d') }}
                    </div>
                </div>
            </div>
        @empty
            @include('h5.components.none')
        @endforelse
    </div>

    @if($orders->total() > $orders->perPage())
        <div class="box">
            {!! str_replace('pagination', 'pagination justify-content-center', $orders->render('pagination::simple-bootstrap-4')) !!}
        </div>
    @endif

@endsection