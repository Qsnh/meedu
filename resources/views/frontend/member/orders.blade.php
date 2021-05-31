@extends('frontend.layouts.member')

@section('member')

    @forelse($orders as $orderItem)
        <div class="bg-white p-5 shadow rounded mb-5">
            <div class="flex items-center text-sm text-gray-500">
                <div class="flex-1">
                    <div class="font-medium text-xl mb-3 text-gray-800">{{$orderItem['order_id']}}</div>
                    <div>
                        <span>{{ implode(',', array_column($orderItem['goods'] ?? [], 'goods_name')) }}</span>
                        <span class="text-gray-300">-</span>
                        <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($orderItem['created_at'])->format('Y-m-d') }}</span>
                    </div>
                    <div class="mt-3">
                        <span class="text-red-500 font-medium">
                            <small>{{__('￥')}}</small>{{ $orderItem['charge'] }}
                        </span>
                    </div>
                </div>
                <div class="ml-3">
                    {{$orderItem['status_text']}}
                </div>
            </div>
        </div>
    @empty
        @include('frontend.components.none')
    @endforelse

    <div class="">
        {{$orders->render('frontend.components.common.paginator')}}
    </div>

@endsection