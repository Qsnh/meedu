@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <div class="text-sm">
            <a href="{{route('index')}}" class="text-gray-500 hover:text-blue-600">{{__('首页')}}</a>
            <span class="px-1 text-gray-400">/</span>
            <a href="{{route('courses')}}" class="text-gray-500 hover:text-blue-600">{{__('课程列表')}}</a>
            <span class="px-1 text-gray-400">/</span>
            <span class="text-gray-600">{{$course['title']}}</span>
        </div>
    </div>

    <div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
        <div class="bg-white p-5 rounded shadow lg:flex">
            <div class="w-full pb-5 lg:pb-0 lg:w-auto px-3 lg:px-0 lg:flex-shrink-0 text-center">
                <img src="{{$course['thumb']}}" width="300" class="inline object-cover rounded">
            </div>
            <div class="px-5 lg:px0 lg:flex-1">
                <h2 class="mb-5 lg:flex lg:items-center lg:pt-2">
                    <div class="text-3xl font-bold truncate text-gray-800 text-center w-full lg:w-auto lg:text-left lg:flex-1">
                        {{$course['title']}}
                    </div>
                    <a href="javascript:void(0)"
                       class="hidden lg:flex-shrink-0 lg:block lg:flex lg:items-center btn-like-course {{$isLikeCourse ? 'text-blue-600' : 'text-gray-400'}}"
                       data-url="{{route('ajax.course.like', [$course['id']])}}"
                       data-like-status="{{$isLikeCourse?1:0}}">
                        <i class="iconfont icon-jifen1 inline-block" style="font-size: 30px"></i>
                    </a>
                </h2>
                <div class="h-24 text-gray-500 mb-5 leading-loose text-center lg:text-left overflow-ellipsis overflow-hidden">
                    {{$course['short_description']}}
                </div>
                <div class="w-full lg:w-auto lg:flex">
                    <div class="text-center lg:text-left lg:flex-shrink-0 lg:mr-3">
                        @if($isBuy)
                            @if($firstVideo)
                                <a href="{{route('video.show', [$firstVideo['course_id'], $firstVideo['id'], $firstVideo['slug']])}}"
                                   class="inline-block px-5 rounded py-2 bg-blue-600 text-white text-center text-base hover:bg-blue-500">{{__('开始学习')}}</a>
                            @else
                                <a href="javascript:void(0);" onclick="flashWarning('{{__('暂无视频')}}')"
                                   class="inline-block px-5 rounded py-2 bg-blue-600 text-white text-center text-base hover:bg-blue-500">{{__('开始学习')}}</a>
                            @endif
                        @else
                            @if($course['charge'] > 0)
                                <a href="{{route('member.course.buy', [$course['id']])}}"
                                   class="inline-block text-white rounded px-5 py-2"
                                   style="background-color: #FF5068">
                                    <span>{{__('购买课程')}}</span>
                                    <span><small>{{__('￥')}}</small>{{$course['charge']}}</span>
                                </a>

                                <a href="{{route('role.index')}}"
                                   class="inline-block ml-3 text-white rounded px-5 py-2"
                                   style="background-color: #E1A500">
                                    {{__('VIP会员免费观看')}}
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
        <div class="bg-white p-5 rounded shadow">
            <div class="pb-5">
                @include('frontend.components.common.tabs', ['tabs' => [['name' => __('课程介绍'), 'dom' => 'course-desc'], ['name' => __('课程目录'), 'dom' => 'lessons'], ['name' => __('课程评论'), 'dom' => 'comments'],['name' => __('课程附件'), 'dom' => 'attach-list']], 'active' => 0])
            </div>
            <div class="">
                <div class="course-desc leading-loose text-gray-800 break-all overflow-hidden">
                    {!! $course['render_desc'] !!}
                </div>
                <div class="lessons hidden">
                    @if($chapters)
                        @foreach($chapters as $chapterIndex => $chapter)
                            @if($videosBox = $videos[$chapter['id']] ?? [])@endif
                            <div class="mb-3">
                                <div class="text-sm text-gray-500 hover:text-gray-600 mb-3 flex cursor-pointer vod-chapter-item">
                                    <div class="flex-1 pl-5">
                                        {{$chapter['title']}}
                                    </div>
                                    <div class="flex-shrink-0">
                                        {{__(sprintf('%d个视频', count($videosBox)))}}
                                    </div>
                                    <div class="flex-shrink-0 ml-1 pr-5 arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="inline-block h-4 w-4 {{$loop->first ? 'transform-rotate--180' : ''}}"
                                             fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="bg-gray-100 rounded pt-5 px-5 {{$loop->first ? '' : 'hidden'}}">
                                    @foreach($videosBox as $videoItem)
                                        <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                           class="flex items-center pb-5 group">
                                            <div class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-5 w-5 mr-2 text-gray-500 group-hover:text-gray-700"
                                                     fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1 text-base text-gray-500 group-hover:text-gray-700">
                                                @if($videoItem['charge'] === 0)
                                                    <span class="px-2 py-1 rounded bg-green-500 text-white text-xs">{{__('免费')}}</span>
                                                @else
                                                    @if($videoItem['free_seconds'] > 0)
                                                        <span class="px-2 py-1 rounded bg-green-500 text-white text-xs">{{__('试看')}}</span>
                                                    @endif
                                                @endif
                                                <span>{{$videoItem['title']}}</span>
                                            </div>
                                            <div class="flex-shrink-0 text-gray-400 text-sm">
                                                @if(isset($videoWatchedProgress[$videoItem['id']]))
                                                    @if($videoWatchedProgress[$videoItem['id']]['watched_at'])
                                                        <span>{{__('已看完')}}</span>
                                                    @elseif($videoItem['duration'] > 0)
                                                        <span>{{__('已看')}}{{(int)($videoWatchedProgress[$videoItem['id']]['watch_seconds'] / $videoItem['duration'] * 100)}}%</span>
                                                    @endif
                                                @else
                                                    <span>{{duration_humans($videoItem['duration'])}}</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-gray-100 rounded pt-5 px-5">
                            @foreach($videos[0] ?? [] as $videoItem)
                                <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
                                   class="flex items-center pb-5 group">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5 mr-2 text-gray-500 group-hover:text-gray-700"
                                             fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 text-base text-gray-500 group-hover:text-gray-700">
                                        @if($videoItem['charge'] === 0)
                                            <span class="px-2 py-1 rounded bg-green-500 text-white text-xs">{{__('免费')}}</span>
                                        @else
                                            @if($videoItem['free_seconds'] > 0)
                                                <span class="px-2 py-1 rounded bg-green-500 text-white text-xs">{{__('试看')}}</span>
                                            @endif
                                        @endif
                                        <span>{{$videoItem['title']}}</span>
                                    </div>
                                    <div class="flex-shrink-0 text-gray-400 text-sm">
                                        @if(isset($videoWatchedProgress[$videoItem['id']]))
                                            @if($videoWatchedProgress[$videoItem['id']]['watched_at'])
                                                <span>{{__('已看完')}}</span>
                                            @elseif($videoItem['duration'] > 0)
                                                <span>{{__('已看')}}{{(int)($videoWatchedProgress[$videoItem['id']]['watch_seconds'] / $videoItem['duration'] * 100)}}%</span>
                                            @endif
                                        @else
                                            <span>{{duration_humans($videoItem['duration'])}}</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="comments hidden">
                    @forelse($comments as $commentItem)
                        @continue(!isset($commentUsers[$commentItem['user_id']]))
                        <div class="flex mb-5 bg-gray-100 rounded p-3">
                            <div class="flex-shrink-0 mr-4">
                                <img src="{{$commentUsers[$commentItem['user_id']]['avatar']}}" width="36" height="36"
                                     class="rounded-full object-cover">
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center mb-3">
                                    <div class="text-gray-700 text-sm font-bold">
                                        {{$commentUsers[$commentItem['user_id']]['nick_name']}}
                                    </div>
                                    <div class="text-xs text-gray-500 ml-3">
                                        {{\Carbon\Carbon::parse($commentItem['created_at'])->diffForHumans()}}
                                    </div>
                                </div>
                                <div class="text-gray-700 text-sm leading-loose">
                                    {!! $commentItem['render_content'] !!}
                                </div>
                            </div>
                        </div>
                    @empty
                        @include('frontend.components.none')
                    @endforelse

                    @if($user && $canComment)
                        <div class="w-full rounded">
                            <div class="flex">
                                <div class="flex-shrink-0 mr-5">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{$user['avatar']}}">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div>
                                            <textarea rows="3" placeholder="{{__('请输入评论内容')}}"
                                                      name="comment-content"
                                                      class="w-full rounded bg-gray-200 px-3 py-3 focus:ring-2 focus:ring-blue-600 focus:bg-white"
                                                      required></textarea>
                                    </div>
                                    <div class="mt-3 text-right">
                                        <button type="button"
                                                data-url="{{route('ajax.course.comment', [$course['id']])}}"
                                                class="btn-submit-comment inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            {{__('评论')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="attach-list hidden">
                    @if(!$attach)
                        @include('frontend.components.none')
                    @else
                        @foreach($attach as $attachItem)
                            <div class="flex items-center mb-5 group last:mb-0">
                                <div class="flex-1 text-gray-500 text-base group-hover:text-gray-700">
                                    {{$attachItem['name']}}
                                </div>
                                <div class="flex-shrink-0 px-5 text-gray-400 text-sm">
                                    {{round($attachItem['size']/1024, 2)}}KB
                                </div>
                                <div class="flex-shrink-0">
                                    <a href="{{route('course.attach.download', $attachItem['id'])}}?_t={{time()}}"
                                       class="text-gray-500 group-hover:text-gray-700"
                                       target="_blank">{{__('下载')}}</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection