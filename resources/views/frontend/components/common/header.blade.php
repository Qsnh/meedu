<nav class="bg-white border-b border-gray-100 shadow-lg">
    <div class="w-full px-3 py-3 flex items-center relative lg:max-w-6xl lg:px-0 lg:mx-auto">
        <div class="flex-initial">
            <a href="{{url('/')}}">
                <img src="{{$gConfig['system']['logo']}}" width="121" height="37">
            </a>
        </div>

        <div class="flex-1 px-8 hidden lg:block">
            <a href="{{url('/')}}"
               class="inline-block text-base {{request()->routeIs('index') ? 'text-blue-600 font-bold' : 'text-gray-500'}} hover:text-blue-600 px-5">
                首页
            </a>
            @foreach($gNavs as $item)
                <div class="inline-block relative px-5 nav-menu">
                    <a href="{{$item['url']}}"
                       {!! $item['blank'] ? 'target="_blank"' : '' !!}
                       class="relative text-base {{request()->routeIs(explode(',', $item['active_routes'])) ? 'text-blue-600 font-bold' : 'text-gray-500'}} hover:text-blue-600">
                        {{$item['name']}}
                    </a>
                    @if($item['children'])
                        <div class="absolute z-50 left-1/2 -ml-24 top-full pt-5 hidden children">
                            <div class="float-left shadow-xl bg-white border border-gray-100 rounded">
                                @foreach($item['children'] as $childrenItem)
                                    <a class="block w-48 text-center float-left px-5 py-2 text-base text-gray-500 hover:bg-gray-100 overflow-hidden {{$loop->first ? 'rounded-tl rounded-tr' : ''}} {{$loop->last ? 'rounded-bl rounded-br' : ''}}"
                                       {!! $childrenItem['blank'] ? 'target="_blank"' : '' !!}
                                       href="{{$childrenItem['url']}}">{{$childrenItem['name']}}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="hidden lg:block lg:flex-initial lg:ml-5 lg:mr-10">
            <form action="{{route('search')}}" class="relative" method="get">
                <input type="text" name="keywords"
                       class="w-60 text-sm px-3 py-2 border border-gray-200 rounded outline-none"
                       required
                       placeholder="{{__('按回车键搜索')}}">
            </form>
        </div>

        <div class="flex-1 flex justify-end items-center lg:flex-initial lg:block">
            <a href="javascript:void(0)" class="show-mobile-menu mr-3 lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block text-gray-600 h-6 w-6" fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </a>

            @if(!$user)
                <a href="{{route('login')}}"
                   class="text-sm px-4 py-2 text-white rounded bg-gradient-to-r from-blue-400 to-indigo-600 hover:from-blue-500 hover:to-indigo-700">登录</a>
            @else
                <div class="inline-block relative nav-menu">
                    <a href="{{route('member')}}"
                       class="text-base text-gray-700">
                        <img class="rounded-full border-2"
                             src="{{$user['avatar']}}"
                             width="40" height="40">
                    </a>
                    <div class="absolute z-50 right-0 top-full pt-5 hidden children">
                        <div class="float-left shadow-xl bg-white border border-gray-100 rounded">
                            <a class="block w-40 flex items-center justify-center float-left px-5 py-2 text-base text-gray-500 hover:bg-gray-100 overflow-hidden rounded-tl rounded-tr"
                               href="{{route('member')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                                <span class="ml-1">用户中心</span>
                            </a>
                            <a class="block w-40 flex items-center justify-center float-left px-5 py-2 text-base text-gray-500 hover:bg-gray-100 overflow-hidden rounded-tl rounded-tr"
                               href="{{route('member')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="ml-1">我的资料</span>
                            </a>
                            <a class="block w-40 flex items-center justify-center float-left px-5 py-2 text-base text-gray-500 hover:bg-gray-100 overflow-hidden rounded-bl rounded-br"
                               href="javascript:void(0);"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-4 w-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span class="ml-1">安全退出</span>
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

        <!-- 小屏幕端菜单 -->
        <div class="mobile-menu hidden absolute z-50 top-full left-10 right-10 bg-white p-3 rounded-lg border border-gray-100 shadow-xl text-center">
            <a href="{{url('/')}}"
               class="block py-2 text-base {{request()->routeIs('index') ? 'text-gray-900' : 'text-gray-500'}}">
                首页
            </a>
            @foreach($gNavs as $item)
                <a href="{{$item['url']}}"
                   class="block py-2 text-base {{request()->routeIs(explode(',', $item['active_routes'])) ? 'text-gray-900' : 'text-gray-500'}}">
                    {{$item['name']}}
                </a>
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