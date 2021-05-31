@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <div class="bg-white rounded shadow p-5">
            <div class="text-xl text-gray-800 font-bold mb-10">{{__('手动打款')}}</div>
            <div class="flex items-center">
                <div class="flex-1">
                    <div class="text-gray-500 py-2 flex items-center">
                        <div class="mr-3">{{__('订单号')}}</div>
                        <div class="flex-1">{{$order['order_id']}}</div>
                    </div>
                    <div class="flex py-2 items-center">
                        <div class="mr-3 text-gray-500">{{__('需支付金额')}}</div>
                        <div class="flex-1">
                            <span class="text-red-500 font-bold text-xl"><small>{{__('￥')}}</small>{{$needPaidTotal}}</span>
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0 ml-10 flex">
                    <div>
                        <a href="{{route('member.orders')}}"
                           class="rounded px-8 py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            <span class="ml-1">{{__('已完成支付')}}</span>
                        </a>
                    </div>
                    <div>
                        <a href="{{route('index')}}"
                           class="ml-5 rounded px-8 py-3 border border-blue-600 text-blue-600 text-center text-base hover:text-blue-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="ml-1">{{__('取消支付')}}</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-10">
                <div class="flex justify-center">
                    {!! QrCode::size(300)->generate($qrcodeUrl); !!}
                </div>
                <div class="text-gray-500 text-center">
                    {{__('请使用微信扫描上方二维码支付')}}
                </div>
            </div>
        </div>
    </div>

@endsection