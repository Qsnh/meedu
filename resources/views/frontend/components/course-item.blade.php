<a href="{{route('course.show', [$course['id'], $course['slug']])}}"
   class="col-span-1 shadow rounded-lg bg-white hover:shadow-lg live-course-item group">
    <div class="w-full thumb-box rounded-t-lg">
        <img src="{{$course['thumb']}}" class="rounded-t-lg" width="100%"
             alt="{{$course['title']}}">
    </div>
    <div class="w-full pt-2 px-2 text-gray-500 group-hover:text-gray-800">
        {{$course['title']}}
    </div>
    <div class="w-full flex py-2 px-2 items-center">
        <div class="flex-1">
            @if($course['is_free'])
                <span class="text-green-500 text-sl">免费</span>
            @else
                @if($course['charge'])
                    <span class="text-red-500 text-base"><small>￥</small>{{$course['charge']}}</span>
                @else
                    <span class="text-red-500 text-base">单节视频购买</span>
                @endif
            @endif
        </div>
        <div class="px-2 text-gray-500 text-sm flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="ml-1">{{$course['user_count']}}</span>
        </div>
    </div>
</a>