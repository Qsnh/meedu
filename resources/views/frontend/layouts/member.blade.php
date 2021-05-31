@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
        <div class="flex py-10">
            <div class="w-72 flex-initial">
                <nav class="space-y-1">
                    <a href="{{route('member')}}"
                       class="{{request()->routeIs(['member']) ? 'bg-white text-blue-600' : 'text-gray-800'}} hover:bg-white group rounded px-3 py-2 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="{{request()->routeIs(['member']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'}} flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span class="truncate">{{__('用户中心')}}</span>
                    </a>

                    <a href="{{route('member.profile')}}"
                       class="{{request()->routeIs(['member.profile']) ? 'bg-white text-blue-600' : 'text-gray-800'}} hover:bg-white group rounded px-3 py-2 flex items-center text-sm font-medium">
                        <svg class="{{request()->routeIs(['member.profile']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'}} flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="truncate">{{__('我的资料')}}</span>
                    </a>

                    <a href="{{route('member.courses')}}"
                       class="{{request()->routeIs(['member.courses']) ? 'bg-white text-blue-600' : 'text-gray-800'}} hover:bg-white group rounded px-3 py-2 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="{{request()->routeIs(['member.courses']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'}} flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/>
                        </svg>
                        <span class="truncate">{{__('录播课程')}}</span>
                    </a>

                    <a href="{{route('member.orders')}}"
                       class="{{request()->routeIs(['member.orders']) ? 'bg-white text-blue-600' : 'text-gray-800'}} hover:bg-white group rounded px-3 py-2 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="{{request()->routeIs(['member.orders']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'}} flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span class="truncate">{{__('我的订单')}}</span>
                    </a>

                    <a href="{{route('member.messages')}}"
                       class="{{request()->routeIs(['member.messages']) ? 'bg-white text-blue-600' : 'text-gray-800'}} hover:bg-white group rounded px-3 py-2 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="{{request()->routeIs(['member.messages']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'}} flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{__('我的消息')}}</span>
                    </a>

                    <a href="{{route('member.promo_code')}}"
                       class="{{request()->routeIs(['member.promo_code']) ? 'bg-white text-blue-600' : 'text-gray-800'}} hover:bg-white group rounded px-3 py-2 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="{{request()->routeIs(['member.promo_code']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'}} flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                        <span class="truncate">{{__('我的邀请')}}</span>
                    </a>

                    <a href="{{route('member.credit1_records')}}"
                       class="{{request()->routeIs(['member.credit1_records']) ? 'bg-white text-blue-600' : 'text-gray-800'}} hover:bg-white group rounded px-3 py-2 flex items-center text-sm font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="{{request()->routeIs(['member.credit1_records']) ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500'}} flex-shrink-0 -ml-1 mr-3 h-6 w-6"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                        </svg>
                        <span class="truncate">{{__('积分明细')}}</span>
                    </a>
                </nav>
            </div>
            <div class="flex-1 ml-5">
                @yield('member')
            </div>
        </div>
    </div>

@endsection