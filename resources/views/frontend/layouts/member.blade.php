@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
        <div class="flex py-10">
            <div class="w-48 flex-initial">
                <nav class="bg-white rounded py-2 space-y-1">
                    <a href="{{route('member')}}"
                       class="{{request()->routeIs(['member']) ? 'bg-white text-blue-600 font-medium' : 'text-gray-500'}} hover:bg-white group rounded px-3 py-3 flex items-center text-base">
                        <i class="iconfont icon-banjiguanli2x inline-block mr-2" style="font-size: 20px"></i>
                        <span class="truncate">{{__('用户中心')}}</span>
                    </a>

                    <a href="{{route('member.profile')}}"
                       class="{{request()->routeIs(['member.profile']) ? 'bg-white text-blue-600 font-medium' : 'text-gray-500'}} hover:bg-white group rounded px-3 py-3 flex items-center text-base">
                        <i class="iconfont icon-zhanghaoquanxian_moren2x inline-block mr-2" style="font-size: 20px"></i>
                        <span class="truncate">{{__('我的资料')}}</span>
                    </a>

                    <a href="{{route('member.courses')}}"
                       class="{{request()->routeIs(['member.courses']) ? 'bg-white text-blue-600 font-medium' : 'text-gray-500'}} hover:bg-white group rounded px-3 py-3 flex items-center text-base">
                        <i class="iconfont icon-tikuziyuan_moren2x inline-block mr-2" style="font-size: 20px"></i>
                        <span class="truncate">{{__('点播课程')}}</span>
                    </a>

                    <a href="{{route('member.orders')}}"
                       class="{{request()->routeIs(['member.orders']) ? 'bg-white text-blue-600 font-medium' : 'text-gray-500'}} hover:bg-white group rounded px-3 py-3 flex items-center text-base">
                        <i class="iconfont icon-zhuanyeguanli2x inline-block mr-2" style="font-size: 20px"></i>
                        <span class="truncate">{{__('我的订单')}}</span>
                    </a>

                    <a href="{{route('member.messages')}}"
                       class="{{request()->routeIs(['member.messages']) ? 'bg-white text-blue-600 font-medium' : 'text-gray-500'}} hover:bg-white group rounded px-3 py-3 flex items-center text-base">
                        <i class="iconfont icon-xioaxi inline-block mr-2" style="font-size: 20px"></i>
                        <span class="truncate">{{__('我的消息')}}</span>
                    </a>

                    <a href="{{route('member.promo_code')}}"
                       class="{{request()->routeIs(['member.promo_code']) ? 'bg-white text-blue-600 font-medium' : 'text-gray-500'}} hover:bg-white group rounded px-3 py-3 flex items-center text-base">
                        <i class="iconfont icon-xueyuanguanli2x1 inline-block mr-2" style="font-size: 20px"></i>
                        <span class="truncate">{{__('邀请码')}}</span>
                    </a>

                    <a href="{{route('member.credit1_records')}}"
                       class="{{request()->routeIs(['member.credit1_records']) ? 'bg-white text-blue-600 font-medium' : 'text-gray-500'}} hover:bg-white group rounded px-3 py-3 flex items-center text-base">
                        <i class="iconfont icon-jifen inline-block mr-2" style="font-size: 20px"></i>
                        <span class="truncate">{{__('积分明细')}}</span>
                    </a>

                    {!! view_hook(\App\Meedu\Hooks\Constant\PositionConstant::VIEW_MEMBER_INDEX_LEFT_MENUS) !!}
                </nav>
            </div>
            <div class="flex-1 ml-5">
                @yield('member')
            </div>
        </div>
    </div>

@endsection