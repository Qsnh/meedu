@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="my-orders">
                    @forelse($orders as $order)
                        <div class="orders-item">
                            @if(count($order['goods']) > 1 || count($order['goods']) === 0)
                                <img src="/images/icons/order-goods.png" width="24" height="24">
                            @else
                                @switch($order['goods'][0]['goods_type'])
                                    @case(\App\Constant\FrontendConstant::ORDER_GOODS_TYPE_COURSE)
                                    <img src="/images/icons/course-hover.png" width="24" height="24">
                                    @break
                                    @case(\App\Constant\FrontendConstant::ORDER_GOODS_TYPE_ROLE)
                                    <img src="/images/icons/member/vip.png" width="24" height="24">
                                    @break
                                    @default
                                    <img src="/images/icons/order-goods.png" width="24" height="24">
                                @endswitch
                            @endif
                            <span class="order-goods-title">{{ implode(',', array_column($order['goods'] ?? [], 'goods_text')) }}</span>

                            <span class="order-goods-status member-list-item-right">{{$order['status_text']}}</span>
                            <span class="order-goods-payment member-list-item-right">{{$order['payment_text'] ?: '暂无'}}</span>
                            <span class="order-goods-date member-list-item-right">{{ \Carbon\Carbon::parse($order['created_at'])->format('Y-m-d') }}</span>
                            <span class="order-goods-charge member-list-item-right">￥{{ $order['charge'] }}</span>
                        </div>
                    @empty
                        @include('frontend.components.none')
                    @endforelse
                </div>
            </div>

            @if($orders->total() > $orders->perPage())
                <div class="col-12">
                    {!! str_replace('pagination', 'pagination justify-content-center', $orders->render()) !!}
                </div>
            @endif
        </div>
    </div>

@endsection