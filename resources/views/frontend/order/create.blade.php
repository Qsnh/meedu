@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <form action="" method="post" class="create-order-form"
              data-message-payment-required="{{__('请选择支付方式')}}">

            <input type="hidden" name="goods_id" value="{{$goods['id']}}">
            <input type="hidden" name="promo_code_id" value="">
            <input type="hidden" name="payment_scene" value="{{$scene}}">
            <input type="hidden" name="payment_sign"
                   value="{{$payments->isNotEmpty() ? $payments->first()['sign'] : ''}}">

            @csrf
            <div class="bg-white shadow p-5 rounded">
                <!-- 订阅信息 -->
                <div class="text-base text-gray-500 mb-6">{{__('订阅信息')}}</div>
                <div class="flex items-center mb-10">
                    <div class="flex-shrink-0 mr-5">
                        <img src="{{$goods['thumb']}}" width="160" height="120" class="object-cover rounded">
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-gray-800 text-xl mb-5">{{$goods['title']}}</div>
                        <div>
                            <span class="px-2 py-1 border border-blue-600 text-blue-600 rounded text-sm">{{$goods['label']}}</span>
                        </div>
                    </div>
                    <div class="text-red-500 text-2xl font-bold">
                        <small>{{__('￥')}}</small>{{$goods['charge']}}
                    </div>
                </div>

                <!-- 邀请码/优惠码 -->
                <div class="text-base text-gray-500 mb-6">{{__('邀请码/优惠码')}}</div>
                <div class="mb-10 flex items-center">
                    <div class="flex-shrink-0">
                        <input type="text" name="promo_code"
                               placeholder="{{__('邀请码/优惠码')}}"
                               class="w-48 rounded bg-gray-200 px-3 py-3 focus:ring-2 focus:ring-blue-600 focus:bg-white">
                    </div>
                    <div class="flex-shrink-0 mx-5">
                        <button type="button"
                                data-url="{{route('ajax.promo_code.check')}}"
                                class="btn-promo-code-check rounded px-8 py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                            {{__('验证')}}
                        </button>
                    </div>
                    <div class="flex-1 promo-code-check-info text-red-500 test-sm"></div>
                </div>

                <!-- 支付方式 -->
                <div class="text-base text-gray-500 mb-6">{{__('支付方式')}}</div>
                <div class="mb-10 flex items-center">
                    @foreach($payments as $payment)
                        <a href="javascript:void(0)"
                           class="btn-payment-item mr-10 border-2 {{$loop->first ? 'border-blue-600' : 'border-gray-200'}} rounded px-5 py-3">
                            <img src="{{$payment['logo']}}" width="170" height="60"
                                 class="object-cover rounded"
                                 data-payment="{{$payment['sign']}}">
                        </a>
                    @endforeach
                </div>

                <div class="border-t border-gray-200 flex items-center py-12">
                    <div class="flex-shrink-0">
                        <span class="text-red-500">{{__('请在30分钟内完成支付')}}</span>
                    </div>
                    <div class="flex-1 text-right">
                        <div class="mb-3">
                            <span>{{__('已抵扣')}}</span>
                            <span class="promo-code-discount text-xl text-red-500 mr-1">
                            <small>{{__('￥')}}</small><span class="promo-code-discount-value">0</span>
                       </span>
                        </div>
                        <div>
                            {{__('总计支付')}}
                            <span class="total text-2xl font-bold text-red-500 mr-1">
                            <small>{{__('￥')}}</small><span data-total="{{$goods['charge']}}"
                                                            class="total-value">{{$goods['charge']}}</span>
                        </span>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit"
                            data-url="{{route('ajax.promo_code.check')}}"
                            class="btn-submit-order rounded px-8 py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                        {{__('立即支付')}}
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection