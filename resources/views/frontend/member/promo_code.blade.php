@extends('frontend.layouts.member')

@section('member')

    @if($userPromoCode)
        <div class="bg-white rounded shadow p-5">
            <div class="grid grid-cols-3">
                <div>
                    <div class="text-gray-500 text-sm mb-5 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1">{{__('邀请码')}}</span>
                    </div>
                    <div class="text-gray-800 text-2xl font-medium text-center">
                        {{$userPromoCode['code']}}
                    </div>
                </div>

                <div>
                    <div class="text-gray-500 text-sm mb-5 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-1">{{__('邀请余额')}}</span>
                    </div>
                    <div class="text-gray-800 text-2xl font-medium text-center">
                        <span><small>{{__('￥')}}</small>{{$user['invite_balance']}}</span>
                        <a href="javascript:void(0)" onclick="$('.withdraw-box-shadow').toggle(200)"
                           class="text-sm text-blue-600 ml-1">{{__('提现')}}</a>
                    </div>
                </div>

                <div>
                    <div class="text-gray-500 text-sm mb-5 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5" fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="ml-1">{{__('已邀请人数')}}</span>
                    </div>
                    <div class="text-gray-800 text-2xl font-medium text-center">
                        {{$inviteCount}}
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white mt-5 p-5 shadow rounded leading-loose text-gray-600 text-sm">
            <div class="flex items-center text-gray-800 font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
                <span class="ml-1">{{__('邀请奖励规则')}}</span>
            </div>
            <div class="px-3 pt-3">
                <p>1.{{sprintf(__('使用该邀请码的用户将获得%d元的抵扣'), $userPromoCode['invited_user_reward'])}}</p>
                <p>
                    2.{{sprintf(__('当用户使用您的邀请码支付并完成订单的时候，您也将获得%d元奖励'), $userPromoCode['invite_user_reward'])}}
                </p>
                <p>
                    3.{{sprintf(__('使用您的邀请码完成支付的用户将会自动成为您的下级，TA的每一笔已支付订单您都将享有%d%%的抽成'), $inviteConfig['per_order_draw']*100)}}
                </p>
            </div>
        </div>

        <div class="bg-white rounded shadow py-5 mt-5">
            <div class="grid grid-cols-3 gap-6">
                <a href="?scene="
                   class="block text-center {{!$scene ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-gray-600'}}">
                    <div class="mb-2">
                        <i class="iconfont icon-yaoqingjilu inline-block"
                           style="font-size: 30px"></i>
                    </div>
                    <div class="text-sm">{{__('邀请记录')}}</div>
                </a>

                <a href="?scene=records"
                   class="block text-center {{$scene === 'records' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-gray-600'}}">
                    <div class="mb-2">
                        <i class="iconfont icon-yue inline-block"
                           style="font-size: 30px"></i>
                    </div>
                    <div class="text-sm">{{__('余额明细')}}</div>
                </a>

                <a href="?scene=withdraw"
                   class="block text-center {{$scene === 'withdraw' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-gray-600'}}">
                    <div class="mb-2">
                        <i class="iconfont icon-tixian inline-block"
                           style="font-size: 30px"></i>
                    </div>
                    <div class="text-sm">{{__('提现明细')}}</div>
                </a>
            </div>
        </div>

        <div class="mt-5">
            @if(!$scene)

                @if($inviteUsers->isNotEmpty())
                    @foreach($inviteUsers as $item)
                        <div class="bg-white px-5 py-3 rounded shadow mb-3">
                            <div class="flex items-center">
                                <div class="flex-1 text-gray-500">
                                    {{substr($item['mobile'], 0, 3)}}****{{substr($item['mobile'], -4, 4)}}
                                </div>
                                <div class="ml-3 text-xs text-gray-400">
                                    <span>{{$item['created_at']}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-2">
                        {{$inviteUsers->render('frontend.components.common.paginator')}}
                    </div>
                @else
                    @include('frontend.components.none')
                @endif

            @elseif($scene === 'records')

                @if($balanceRecords->isNotEmpty())
                    @foreach($balanceRecords as $item)
                        <div class="bg-white px-5 py-3 rounded shadow mb-3">
                            <div class="flex items-center">
                                <div class="flex-1 text-gray-500">
                                    <div class="text-gray-500 text-sm mb-3">{{$item['desc']}}</div>
                                    <div class="font-medium">
                                        @if($item['total'] > 0)
                                            <span class="text-gray-800">+{{$item['total']}}</span>
                                        @else
                                            <span class="text-red-500">{{$item['total']}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-3 text-xs text-gray-400">
                                    <span>{{$item['created_at']}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-2">
                        {{$balanceRecords->render('frontend.components.common.paginator')}}
                    </div>
                @else
                    @include('frontend.components.none')
                @endif

            @elseif($scene === 'withdraw')

                @if($withdrawOrders->isNotEmpty())
                    @foreach($withdrawOrders as $item)
                        <div class="bg-white px-5 py-3 rounded shadow mb-3">
                            <div class="flex items-center">
                                <div class="flex-1 text-gray-500">
                                    <div class="text-gray-500 text-sm mb-3">{{$item['status_text']}}</div>
                                    <div class="text-gray-500 text-sm mb-3">
                                        <span>{{$item['channel']}}</span>
                                        <span class="text-gray-300">-</span>
                                        <span>{{$item['channel_name']}}</span>
                                        <span class="text-gray-300">-</span>
                                        <span>{{$item['channel_account']}}</span>
                                    </div>
                                    <div class="font-medium">
                                        <span class="text-gray-800">{{__('￥')}}{{$item['total']}}</span>
                                    </div>
                                </div>
                                <div class="ml-3 text-xs text-gray-400">
                                    <span>{{$item['created_at']}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="pt-2">
                        {{$withdrawOrders->render('frontend.components.common.paginator')}}
                    </div>
                @else
                    @include('frontend.components.none')
                @endif

            @endif
        </div>

        <div class="withdraw-box-shadow">
            <div class="close-button border-2 border-gray-200 p-2 rounded-full cursor-pointer text-gray-200 hover:text-white hover:border-white"
                 onclick="$('.withdraw-box-shadow').toggle(200)">
                <svg class="inline-block w-7 h-7" xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div class="withdraw-box w-full md:w-96 md:left-1/2 md:-ml-48">
                <div class="w-full p-5 bg-white rounded-lg">
                    <div class="w-full mb-5 flex items-center">
                        <div class="flex-1">
                            <h1 class="text-xl font-bold text-gray-800">{{__('提现')}}</h1>
                        </div>
                        <div class="flex-initial ml-3">
                            <a href="javascript:void(0)"
                               data-message-required="{{__('请输入支付宝账号，姓名，提现金额')}}"
                               data-message-success="{{__('成功')}}"
                               data-url="{{route('ajax.invite_balance.withdraw')}}"
                               class="btn-submit-withdraw rounded px-3 py-2 bg-blue-600 text-white text-center text-base hover:bg-blue-500">{{__('申请提现')}}</a>
                        </div>
                    </div>
                    <form class="withdraw-form">
                        <div class="w-full mb-3">
                            <div class="text-gray-400 text-sm mb-1">
                                <span class="text-red-500">*</span>{{__('支付宝账户')}}
                            </div>
                            <div>
                                <input type="text" name="account" placeholder="{{__('支付宝账户')}}"
                                       class="w-full rounded border-b border-gray-200 bg-gray-200 px-3 py-2 text-sm focus:ring-1 focus:ring-blue-600 focus:bg-white resize-none"/>
                            </div>
                        </div>
                        <div class="w-full mb-3">
                            <div class="text-gray-400 text-sm mb-1">
                                <span class="text-red-500">*</span>{{__('真实姓名')}}
                            </div>
                            <div>
                                <input type="text" name="name" placeholder="{{__('真实姓名')}}"
                                       class="w-full rounded border-b border-gray-200 bg-gray-200 px-3 py-2 text-sm focus:ring-1 focus:ring-blue-600 focus:bg-white resize-none"/>
                            </div>
                        </div>
                        <div class="w-full">
                            <div class="text-gray-400 text-sm mb-1">
                                <span class="text-red-500">*</span>{{__('提现金额')}}
                            </div>
                            <div>
                                <input type="number" name="total" placeholder="{{__('提现金额')}}"
                                       class="w-full rounded border-b border-gray-200 bg-gray-200 px-3 py-2 text-sm focus:ring-1 focus:ring-blue-600 focus:bg-white resize-none"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @else
        <div class="bg-white rounded shadow p-5">
            <div class="py-10 text-center text-gray-500">
                {{__('无权限')}}
            </div>
        </div>
    @endif

@endsection