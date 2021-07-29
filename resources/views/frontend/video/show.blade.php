@extends('frontend.layouts.app')

@section('css')
    <style>
        @if($video['ban_drag'] === 1)
        .dplayer-bar-wrap {
            display: none
        }
        @endif
    </style>

@section('content')

    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <div class="text-sm">
            <a href="{{route('index')}}" class="text-gray-500 hover:text-gray-600">{{__('首页')}}</a>
            <span class="px-1 text-gray-400">/</span>
            <a href="{{route('courses')}}" class="text-gray-500 hover:text-gray-600">{{__('点播课程')}}</a>
            <span class="px-1 text-gray-400">/</span>
            <a href="{{route('course.show', [$course['id'], $course['slug']])}}"
               class="text-gray-500 hover:text-gray-600">{{$course['title']}}</a>
            <span class="px-1 text-gray-400">/</span>
            <span class="text-gray-600">{{$video['title']}}</span>
        </div>
    </div>

    <div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
        <div class="bg-gray-900 rounded">
            @if($user)
                @if($canSeeVideo)
                    <div class="player-render-box">
                        @include('frontend.components.player.dplayer', ['videoItem' => $video, 'isTry' => false])
                    </div>

                    @if($nextVideo)
                    <!-- 还有下一集 -->
                        <div class="video-play-alert-info hidden">
                            <div class="py-20 px-10 text-gray-100 text-base">
                                <span class="text-sm">{{__('下一集')}}</span>
                                <a class="ml-3 text-blue-600 text-xl font-medium hover:text-blue-700"
                                   href="{{route('video.show', [$nextVideo['course_id'], $nextVideo['id'], $nextVideo['slug']])}}">
                                    {{$nextVideo['title']}}
                                </a>
                            </div>
                        </div>
                    @else
                    <!-- 最后一集了，您终于看完啦 -->
                        <div class="video-play-alert-info hidden">
                            <div class="py-20 px-10 text-gray-100 text-2xl font-medium">
                                <span>Wow!{{__('课程已全部看完')}}</span>
                            </div>
                        </div>
                    @endif
                @else
                <!-- 无法观看当前视频 -->
                    @if($trySee)
                    <!-- 当前视频配置了试看，可以试看N秒，结束后提示购买 -->
                        <div class="player-render-box">
                            @include('frontend.components.player.dplayer', ['videoItem' => $video, 'isTry' => true])
                        </div>

                        <div class="video-play-alert-info hidden">
                            <div class="text-center pt-20 text-white text-xl font-medium mb-10">{{$video['title']}}</div>
                            <div class="text-center pb-20">
                                <span class="text-gray-100 text-sm">{{__('观看完整视频请订阅')}}</span>
                                @if($course['charge'] > 0)
                                    <a href="{{route('member.course.buy', [$course['id']])}}"
                                       class="ml-3 text-sm px-4 py-2 text-white rounded bg-blue-600 hover:bg-blue-500">
                                        {{__('购买课程')}}
                                        {{__('￥')}}{{$course['charge']}}
                                    </a>
                                @endif

                                @if($video['is_ban_sell'] === 0 && $video['charge'] > 0)
                                    <a href="{{route('member.video.buy', [$video['id']])}}"
                                       class="ml-3 text-sm px-4 py-2 text-white rounded bg-blue-600 hover:bg-blue-500">
                                        {{__('购买该视频')}}
                                        {{__('￥')}}{{$video['charge']}}
                                    </a>
                                @endif

                                <a href="{{route('role.index')}}"
                                   class="ml-3 text-sm px-4 py-2 rounded text-white bg-gradient-to-r from-yellow-400 to-yellow-800 hover:to-yellow-900 hover:from-yellow-500">
                                    {{__('VIP会员免费观看')}}
                                </a>
                            </div>
                        </div>
                    @else
                    <!-- 提示订阅视频 -->
                        <div class="video-play-alert-info">
                            <div class="text-center pt-20 text-white text-xl font-medium mb-10">{{$video['title']}}</div>
                            <div class="text-center pb-20">
                                <span class="text-gray-100 text-sm">{{__('请订阅后观看')}}</span>
                                @if($course['charge'] > 0)
                                    <a href="{{route('member.course.buy', [$course['id']])}}"
                                       class="ml-3 text-sm px-4 py-2 text-white rounded bg-blue-600 hover:bg-blue-500">
                                        {{__('购买课程')}}
                                        {{__('￥')}}{{$course['charge']}}
                                    </a>
                                @endif

                                @if($video['is_ban_sell'] === 0 && $video['charge'] > 0)
                                    <a href="{{route('member.video.buy', [$video['id']])}}"
                                       class="ml-3 text-sm px-4 py-2 text-white rounded bg-blue-600 hover:bg-blue-500">
                                        {{__('购买该视频')}}
                                        {{__('￥')}}{{$video['charge']}}
                                    </a>
                                @endif

                                <a href="{{route('role.index')}}"
                                   class="ml-3 text-sm px-4 py-2 rounded text-white bg-gradient-to-r from-yellow-400 to-yellow-800 hover:to-yellow-900 hover:from-yellow-500">
                                    {{__('VIP会员免费观看')}}
                                </a>
                            </div>
                        </div>
                    @endif
                @endif
            @else
            <!-- 未登录状态，提示登录后观看 -->
                <div class="video-play-alert-info">
                    <div class="text-center pt-20 text-white text-xl font-medium mb-10">{{$video['title']}}</div>
                    <div class="text-center pb-20">
                        <span class="text-gray-100 text-sm">{{__('请登录后观看')}}</span>
                        <a href="{{route('login', ['redirect' => request()->fullUrl()])}}"
                           class="ml-3 text-sm px-4 py-2 text-white rounded bg-blue-600 hover:bg-blue-500">{{__('登录')}}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
        <div class="bg-white p-5 rounded shadow">
            <div class="pb-5">
                @include('frontend.components.common.tabs', ['tabs' => [['name' => __('课程目录'), 'dom' => 'lessons'], ['name' => __('视频评论'), 'dom' => 'comments']], 'active' => 0])
            </div>
            <div class="px-3">
                <div class="lessons">
                    @if($chapters)
                        @foreach($chapters as $chapterIndex => $chapter)
                            @if($videosBox = $videos[$chapter['id']] ?? [])@endif
                            <div class="mb-3">
                                <div class="text-sm text-gray-500 mb-3 flex vod-chapter-item cursor-pointer">
                                    <div class="flex-1 pl-5">
                                        {{$chapter['title']}}
                                    </div>
                                    <div class="flex-shrink-0">
                                        {{__(sprintf('%d个视频', count($videosBox)))}}
                                    </div>
                                    <div class="flex-shrink-0 ml-1 pr-5 arrow">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="inline-block h-4 w-4 {{in_array($video['id'], array_column($videosBox, 'id')) ? 'transform-rotate--180' : ''}}"
                                             fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="bg-gray-100 rounded pt-5 px-5 {{in_array($video['id'], array_column($videosBox, 'id')) ? '' : 'hidden'}}">
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
                                            <div class="flex-1 text-base {{$video['id'] === $videoItem['id'] ? 'font-medium text-blue-600 group-hover:text-blue-700' : 'text-gray-500 group-hover:text-gray-700'}}">
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
                                    <div class="flex-1 text-base {{$video['id'] === $videoItem['id'] ? 'font-medium text-blue-600 group-hover:text-blue-700' : 'text-gray-500 group-hover:text-gray-700'}}">
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
                        <div class="flex bg-gray-100 rounded p-3 mb-5">
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
                                                data-url="{{route('ajax.video.comment', [$video['id']])}}"
                                                data-message-success="{{__('成功')}}"
                                                class="btn-submit-comment inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            {{__('评论')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script crossorigin="anonymous" integrity="sha384-NowxCVrymxfs88Gx+ygXX3HCvpP7JE1nsDUuIshgWg2gO2eFCaePIdAuOfnG6ZjM"
            src="https://lib.baomitu.com/hls.js/8.0.0-beta.3/hls.min.js"></script>
    <script src="{{asset('/js/dplayer/DPlayer.min.js')}}"></script>
@endsection