<nav class="bg-white border-b border-gray-100 shadow-lg">
    <div class="w-full px-3 lg:w-auto lg:max-w-6xl lg:mx-auto">
        <!-- 顶部栏 -->
        <div class="py-4 flex items-center relative">
            <div class="flex-initial">
                <a href="{{url('/')}}">
                    <img src="{{$gConfig['system']['logo']}}" width="121" height="37"/>
                </a>
            </div>

            <div class="flex-1 pr-12 flex justify-end">
                <div class="search-form-box">
                    <form action="{{route('search')}}" method="get" style="margin-block-end: 0">
                        <div class="relative">
                            <input type="text" name="keywords"
                                   class="search-input border border-gray-200 text-sm outline-none"
                                   autocomplete="off"
                                   required
                                   placeholder="{{__('请输入关键字')}}">
                            <button type="submit" class="btn-search focus:ring-0">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="text-gray-500 hover:text-gray-600 h-5 w-5" fill="none" viewBox="0 0 24 24"
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
                   class="rounded mr-12 text-center color-vip">
                    <div style="height: 20px">
                        <i class="iconfont icon-huiyuan" style="font-size: 20px"></i>
                    </div>
                    <div class="text-sm mt-1 text-center font-medium">{{__('VIP会员')}}</div>
                </a>

                @if(!$user)
                    <a href="{{route('login')}}"
                       class="text-sm py-2 text-gray-500 hover:text-blue-600">{{__('登录')}}</a>
                    <span class="text-gray-300 mx-2">|</span>
                    <a href="{{route('register')}}"
                       class="text-sm py-2 text-gray-500 hover:text-blue-600">{{__('注册')}}</a>
                @else

                    <a href="{{route('member.messages')}}"
                       class="relative rounded mr-12 text-gray-500 text-center hover:text-gray-900">
                        <div style="height: 20px">
                            <i class="iconfont icon-xioaxi" style="font-size: 20px"></i>
                        </div>
                        <div class="text-sm mt-1 text-center">
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
                                <a class="block w-32 text-center float-left px-5 py-2 text-sm text-gray-800 hover:text-blue-600 hover:font-medium rounded-tl rounded-tr"
                                   href="{{route('member')}}">
                                    {{__('用户中心')}}
                                </a>
                                <a class="block w-32 text-center float-left px-5 py-2 text-sm text-gray-800 hover:text-blue-600 hover:font-medium rounded-tl rounded-tr"
                                   href="{{route('member.profile')}}">
                                    {{__('我的资料')}}
                                </a>
                                <a class="block w-32 text-center float-left px-5 py-2 text-sm text-gray-800 hover:text-blue-600 hover:font-medium rounded-bl rounded-br"
                                   href="javascript:void(0);"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{__('安全退出')}}
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
            @foreach($gNavs as $item)
                <div class="inline-block relative {{$loop->first ? 'pr-5' : 'px-5'}} nav-menu">
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