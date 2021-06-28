@extends('frontend.layouts.member')

@section('member')

    <div class="bg-white rounded shadow py-5">
        <div class="grid grid-cols-4 gap-6">
            <a href="?scene="
               class="block text-center {{!$scene ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-gray-600'}}">
                <div class="mb-2">
                    <i class="iconfont icon-zhanghaoquanxian_moren2x inline-block"
                       style="font-size: 30px"></i>
                </div>
                <div class="text-sm">{{__('已购课程')}}</div>
            </a>

            <a href="?scene=videos"
               class="block text-center {{$scene === 'videos' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-gray-600'}}">
                <div class="mb-2">
                    <i class="iconfont icon-yigoushiping inline-block"
                       style="font-size: 30px"></i>
                </div>
                <div class="text-sm">{{__('已购视频')}}</div>
            </a>

            <a href="?scene=history"
               class="block text-center {{$scene === 'history' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-gray-600'}}">
                <div class="mb-2">
                    <i class="iconfont icon-lishi inline-block"
                       style="font-size: 30px"></i>
                </div>
                <div class="text-sm">{{__('观看记录')}}</div>
            </a>

            <a href="?scene=like"
               class="block text-center {{$scene === 'like' ? 'text-blue-600 hover:text-blue-700' : 'text-gray-500 hover:text-gray-600'}}">
                <div class="mb-2">
                    <i class="iconfont icon-jifen1 inline-block"
                       style="font-size: 30px"></i>
                </div>
                <div class="text-sm">{{__('收藏课程')}}</div>
            </a>
        </div>
    </div>

    <div class="pt-5">
        @if($scene === 'videos')
            @if($records->isNotEmpty())
                @foreach($records as $courseId => $videos)
                    @continue(!isset($courses[$courseId]))
                    <div class="mb-5">
                        <div class="flex items-center px-3">
                            <div class="flex-1 truncate text-gray-500 text-sm">
                                {{$courses[$courseId]['title']}}
                            </div>
                            <div class="ml-5">
                                <a class="text-gray-500 hover:text-gray-600 text-sm"
                                   href="{{route('course.show', [$courses[$courseId]['id'], $courses[$courseId]['slug']])}}">更多</a>
                            </div>
                        </div>
                        <div class="mt-2 bg-white px-5 py-3 shadow rounded">
                            @foreach($videos as $videoItem)
                                <a class="block py-2 flex items-center group"
                                   href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}">
                                    <div class="flex-shrink-0 mr-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="block h-4 w-4 text-gray-400"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 text-gray-500 group-hover:text-gray-800">
                                        {{$videoItem['title']}}
                                    </div>
                                    <div class="pl-5 text-sm text-gray-500">
                                        {{duration_humans($videoItem['duration'])}}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                @include('frontend.components.none')
            @endif
        @else
            @if($records->isNotEmpty())
                <div class="grid gap-6 grid-cols-2 lg:grid-cols-4">
                    @foreach($records as $recordItem)
                        @continue(!isset($courses[$recordItem['course_id']]))
                        @include('frontend.components.course-item', ['course' => $courses[$recordItem['course_id']]])
                    @endforeach
                </div>
            @else
                @include('frontend.components.none')
            @endif
        @endif
    </div>

    <div class="pt-5">
        {{$records->render('frontend.components.common.paginator')}}
    </div>

@endsection