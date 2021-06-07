<a href="{{route('course.show', [$course['id'], $course['slug']])}}"
   class="rounded bg-white hover:shadow-lg course-item group">
    <div class="w-full thumb-box rounded-t">
        <img src="{{$course['thumb']}}" class="rounded-t" width="100%"
             alt="{{$course['title']}}">
    </div>
    <div class="w-full pt-2 px-2 text-gray-800 group-hover:text-gray-900 truncate">
        {{$course['title']}}
    </div>
    <div class="w-full flex py-2 px-2 items-center">
        <div class="flex-1 text-gray-500 text-sm">
            {{$course['user_count']}}人已订阅
        </div>
        <div class="flex-shrink-0 px-2">
            @if($course['is_free'])
                <span class="text-green-500 font-medium text-sm">免费</span>
            @else
                @if($course['charge'])
                    <span class="text-red-500 font-medium text-base"><small>￥</small>{{$course['charge']}}</span>
                @else
                    <span class="text-red-500 font-medium text-sm">单节购买</span>
                @endif
            @endif
        </div>
    </div>
</a>