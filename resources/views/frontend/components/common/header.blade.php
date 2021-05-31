<nav class="bg-white border-b border-gray-100 shadow-lg">
    <div class="w-full px-3 lg:w-auto lg:max-w-6xl lg:mx-auto">
        <!-- 顶部栏 -->
        <div class="py-4 flex items-center relative">
            <div class="flex-initial">
                <a href="{{url('/')}}">
                    <img src="{{$gConfig['system']['logo']}}" width="121" height="37"/>
                </a>
            </div>

            <div class="flex-1 px-10 flex justify-center">
                <div class="block" style="width: 360px">
                    <form action="{{route('search')}}" method="get">
                        <div class="flex">
                            <input type="text" name="keywords"
                                   class="flex-1 border border-gray-200 rounded-tl rounded-bl px-3 py-2 text-sm outline-none focus:ring-0 focus:border-gray-200"
                                   autocomplete="off"
                                   required
                                   placeholder="{{__('请输入关键字')}}">
                            <button type="submit"
                                    class="text-sm px-4 py-2 text-sm text-white rounded-tr rounded-br bg-blue-600 hover:bg-blue-500 outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="flex-initial flex items-center">
                <a href="{{route('role.index')}}"
                   class="rounded mr-5 text-blue-600 text-center hover:text-blue-700">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5" fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                    </div>
                    <div class="text-xs text-center font-medium">{{__('VIP会员')}}</div>
                </a>

                @if(!$user)
                    <a href="{{route('login')}}"
                       class="text-sm px-4 py-2 text-white rounded bg-blue-600 hover:bg-blue-500">{{__('登录')}}</a>
                    <a href="{{route('register')}}"
                       class="text-sm px-4 py-2 text-blue-600 border border-blue-600 rounded bg-white ml-2 hover:bg-blue-100">{{__('注册')}}</a>
                @else

                    <a href="{{route('member.messages')}}"
                       class="relative rounded mr-5 text-gray-800 text-center hover:text-gray-900">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="inline-block h-5 w-5"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="text-xs text-center">
                            <span>{{__('我的消息')}}</span>
                        </div>
                        @if($gUnreadMessageCount > 0)
                            <div class="w-2 h-2 bg-red-500 rounded-full absolute top-0 right-0"></div>
                        @endif
                    </a>

                    <div class="inline-block relative nav-menu">
                        <a href="{{route('member')}}"
                           class="text-base text-gray-700">
                            <img class="rounded-full border-2"
                                 src="{{$user['avatar']}}"
                                 width="40" height="40">
                        </a>
                        <div class="absolute z-50 right-0 top-full pt-5 hidden children">
                            <div class="float-left shadow-xl bg-white border border-gray-100 rounded">
                                <a class="block w-32 flex items-center justify-center float-left px-5 py-2 text-base text-gray-800 hover:bg-gray-100 overflow-hidden rounded-tl rounded-tr"
                                   href="{{route('member')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    <span class="ml-2 text-sm">{{__('用户中心')}}</span>
                                </a>
                                <a class="block w-32 flex items-center justify-center float-left px-5 py-2 text-base text-gray-800 hover:bg-gray-100 overflow-hidden rounded-tl rounded-tr"
                                   href="{{route('member.profile')}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="ml-2 text-sm">{{__('我的资料')}}</span>
                                </a>
                                <a class="block w-32 flex items-center justify-center float-left px-5 py-2 text-base text-gray-800 hover:bg-gray-100 overflow-hidden rounded-bl rounded-br"
                                   href="javascript:void(0);"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="ml-2 text-sm">{{__('安全退出')}}</span>
                                </a>

                                <form class="d-none" id="logout-form" action="{{ route('logout') }}"
                                      method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- 导航栏 -->
        <div class="py-4">
            <a href="{{route('index')}}"
               class="inline-block text-base {{request()->routeIs(['index', 'announcement.show']) ? 'text-blue-600 font-bold' : 'text-gray-600'}} hover:text-blue-600 pr-5">
                首页
            </a>
            <a href="{{route('courses')}}"
               class="inline-block text-base {{request()->routeIs(['courses', 'course.show', 'videos', 'video.show', 'search']) ? 'text-blue-600 font-bold' : 'text-gray-600'}} hover:text-blue-600 px-5">
                录播课
            </a>
            @foreach($gNavs as $item)
                <div class="inline-block relative px-5 nav-menu">
                    <a href="{{$item['url']}}"
                       {!! $item['blank'] ? 'target="_blank"' : '' !!}
                       class="relative text-base {{request()->routeIs(explode(',', $item['active_routes'])) ? 'text-blue-600 font-bold' : 'text-gray-600'}} hover:text-blue-600">
                        {{$item['name']}}
                    </a>
                    @if($item['children'])
                        <div class="absolute z-50 left-1/2 -ml-24 top-full pt-5 hidden children">
                            <div class="float-left shadow-xl bg-white border border-gray-100 rounded">
                                @foreach($item['children'] as $childrenItem)
                                    <a class="block w-48 text-center float-left px-5 py-2 text-base text-gray-600 hover:bg-gray-100 overflow-hidden {{$loop->first ? 'rounded-tl rounded-tr' : ''}} {{$loop->last ? 'rounded-bl rounded-br' : ''}}"
                                       {!! $childrenItem['blank'] ? 'target="_blank"' : '' !!}
                                       href="{{$childrenItem['url']}}">{{$childrenItem['name']}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</nav>

<script>
    $('.nav-menu').hover(function () {
        $(this).find('.children').show()
    });
    $('.nav-menu').mouseleave(function () {
        $(this).find('.children').hide()
    });

    $('.show-mobile-menu').click(function () {
        $('.mobile-menu').toggle(200);
    });
</script>