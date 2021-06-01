@extends('frontend.layouts.member')

@section('member')

    <div class="bg-white rounded shadow">
        <div class="px-10 py-10 rounded-t bg-gradient-to-br {{isset($user['role']) ? 'from-yellow-600 to-yellow-300' : 'from-blue-600 to-blue-300'}}">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img src="{{$user['avatar']}}" class="h-20 w-20 rounded-full border-2 border-gray-50">
                </div>
                <div class="flex-1 ml-5">
                    <div class="text-xl font-medium text-white">{{$user['nick_name']}}</div>
                    @if(isset($user['role']))
                        <div class="mt-1">
                            <a href="{{route('member.join_role_records')}}"
                               class="block text-sm text-white">{{$user['role']['name']}}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="px-10 py-10 grid grid-cols-4 gap-6 text-center">
            <div class="">
                <div class="text-gray-500 text-sm mb-5 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                    </svg>
                    <span class="ml-1">{{__('积分')}}</span>
                </div>
                <div class="text-2xl font-medium text-gray-800">
                    {{$user['credit1']}}
                </div>
            </div>
            <div class="">
                <div class="text-gray-500 text-sm mb-5 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"/>
                    </svg>
                    <span class="ml-1">{{__('铜币')}}</span>
                </div>
                <div class="text-2xl font-medium text-gray-800">
                    {{$user['credit2']}}
                </div>
            </div>
            <div class="">
                <div class="text-gray-500 text-sm mb-5 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="ml-1">{{__('邀请')}}</span>
                </div>
                <div class="text-2xl font-medium text-gray-800">
                    {{$inviteCount}}
                </div>
            </div>

            <div>
                <div class="text-gray-500 text-sm mb-5 flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="ml-1">{{__('邀请余额')}}</span>
                </div>
                <div class="text-2xl font-medium text-gray-800">
                    <small>{{__('￥')}}</small>{{$user['invite_balance']}}
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 mb-5">
        <div class="bg-white px-5 rounded shadow">
            <div class="text-gray-800 text-base font-medium pt-5 mb-10">{{__('社交账号')}}</div>
            <div class="pb-10 flex items-center">
            @if((int)$gConfig['mp_wechat']['enabled_scan_login'] === 1)
                <!-- 微信账号绑定 -->
                    <div class="text-center px-10 mr-5">
                        <div class="mb-3">
                            <img src="{{asset('images/icons/wechat.svg')}}" class="inline object-cover" width="30"
                                 height="30">
                        </div>
                        @if(isset($apps[\App\Constant\FrontendConstant::WECHAT_LOGIN_SIGN]))
                            <div class="text-gray-500 text-sm mb-3">
                                {{mb_substr($apps[\App\Constant\FrontendConstant::WECHAT_LOGIN_SIGN]['app_user_id'], 0, 8)}}
                                ***
                            </div>
                            <div>
                                <a href="{{route('member.socialite.delete', [\App\Constant\FrontendConstant::WECHAT_LOGIN_SIGN])}}"
                                   onclick="return confirm('{{__('确认操作？')}}')"
                                   class="text-sm text-blue-600">{{__('取消绑定')}}</a>
                            </div>
                        @else
                            <div>
                                <a href="" class="text-sm text-blue-600">{{__('绑定')}}</a>
                            </div>
                        @endif
                    </div>
            @endif

            <!-- 其它社交账号 -->
                @foreach(enabled_socialites() as $socialiteItem)
                    <div class="text-center px-10 mr-5">
                        <div class="mb-3">
                            <img src="{{$socialiteItem['logo']}}" class="inline object-cover" width="30"
                                 height="30">
                        </div>
                        @if(isset($apps[$socialiteItem['app']]))
                            <div class="text-gray-500 text-sm mb-3">
                                {{mb_substr($apps[$socialiteItem['app']]['app_user_id'], 0, 8)}}
                                ***
                            </div>
                            <div>
                                <a href="{{route('member.socialite.delete', [$socialiteItem['app']])}}"
                                   onclick="return confirm('{{__('确认操作？')}}')"
                                   class="text-sm text-blue-600">{{__('取消绑定')}}</a>
                            </div>
                        @else
                            <div>
                                <a href="{{route('member.socialite.bind', [$socialiteItem['app']])}}"
                                   class="text-sm text-blue-600">{{__('绑定')}}</a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection