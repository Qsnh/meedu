<nav class="bg-white border-b border-gray-100 shadow-lg">
    <div class="w-full px-3 py-5 flex items-center relative md:max-w-6xl md:px-0 md:mx-auto">
        <div class="flex-initial">
            <a href="{{url('/')}}">
                <img src="{{$gConfig['system']['logo']}}" width="121" height="37">
            </a>
        </div>

        <div class="flex-1 px-8 hidden md:block">
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

        <div class="hidden md:block md:flex-initial md:ml-5 md:mr-10">
            <form action="{{route('search')}}" class="relative" method="get">
                <input type="text" name="keywords"
                       class="w-60 text-sm px-3 py-2 border border-gray-200 rounded outline-none"
                       required
                       placeholder="{{__('按回车键搜索')}}">
            </form>
        </div>

        <div class="flex-1 flex justify-end items-center md:flex-initial md:block">
            <a href="javascript:void(0)" class="show-mobile-menu mr-3 md:hidden">
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
                <a href="{{route('member')}}"
                   class="text-base text-gray-700">
                    <img class="rounded-full border-2 border-yellow-500 hover:border-yellow-600"
                         src="{{$user['avatar']}}"
                         width="40" height="40">
                </a>
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