@extends('layouts.app')

@section('css')
    <link href="https://lib.baomitu.com/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
    <link crossorigin="anonymous" integrity="sha384-GcG0k8M8UyMuMIHkOzVr3jjKRJz5u3bs8fYb3csFVv2B7WtnbkaOn6uLZg+o9GtN" href="https://lib.baomitu.com/highlight.js/9.13.1/styles/atelier-forest-dark.min.css" rel="stylesheet">
@endsection

@section('content')

    <div class="container-fluid course-detail-banner">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2 class="color-fff">{{ $course->title }}</h2>
                            <p class="lh-30">
                                <span class="badge badge-primary">
                                    更新于 {{ $course->created_at->diffForHumans() }}
                                </span>
                                @if($course->charge)
                                    <span class="badge badge-danger">价格 {{$course->charge}}元</span>
                                @else
                                    <span class="badge badge-success">免费</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container course-show-box">
        <div class="row">
            <div class="col-sm-9 border course-video-list-box">
                <div class="row course-video-tab">
                    <div class="col-sm-4 course-video-tab-item active" data="list">视频列表</div>
                    <div class="col-sm-4 course-video-tab-item" data="intro">简介</div>
                    <div class="col-sm-4 course-video-tab-item" data="comment">评论</div>
                </div>
               <div class="tab-content-box">
                   <div class="intro" style="display: none">
                       {!! $course->getDescription() !!}
                       <hr>
                       <div class="social-share"></div>
                   </div>
                   <div class="list">
                       <table>
                           <tbody>
                            @if($course->hasChaptersCache())
                                @if($i=0)@endif
                                @forelse($course->getChaptersCache() as $chapter)
                                    <tr class="chapter-title">
                                        <td colspan="2"><span>{{$chapter->title}}</span></td>
                                    </tr>
                                    @foreach($chapter->getVideosCache() as $index => $video)
                                        @if($i++)@endif
                                    <tr>
                                        <td class="index-td">
                                            <span class="index">{{$i}}</span>
                                        </td>
                                        <td>
                                            <h3 class="video-title">
                                                <a href="{{ route('video.show', [$course->id, $video->id, $video->slug]) }}">
                                                    {{ $video->title  }}
                                                </a>
                                            </h3>
                                            <p class="extra">
                                                @if($video->charge > 0)
                                                    <span class="badge badge-danger">收费</span>
                                                @else
                                                    <span class="badge badge-success">免费</span>
                                                @endif
                                                <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{duration_humans($video)}}</span>
                                                    <span><i class="fa fa-play-circle-o" aria-hidden="true"></i> {{ view_num_humans($video) }}</span>
                                            </p>
                                        </td>
                                    </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">暂无数据</td>
                                    </tr>
                                @endforelse

                                @else

                                @forelse($course->getAllPublishedAndShowVideosCache() as $index => $video)
                                   <tr>
                                       <td class="index-td">
                                           <span class="index">{{$index+1}}</span>
                                       </td>
                                       <td>
                                           <h3 class="video-title">
                                                <a href="{{ route('video.show', [$course->id, $video->id, $video->slug]) }}">
                                                    {{ $video->title  }}
                                                </a>
                                            </h3>
                                           <p class="extra">
                                               @if($video->charge > 0)
                                                   <span class="badge badge-danger">收费</span>
                                               @else
                                                   <span class="badge badge-success">免费</span>
                                               @endif
                                                   <span><i class="fa fa-clock-o" aria-hidden="true"></i> {{duration_humans($video)}}</span>
                                                   <span><i class="fa fa-play-circle-o" aria-hidden="true"></i> {{ view_num_humans($video) }}</span>
                                           </p>
                                       </td>
                                   </tr>
                                @empty
                                   <tr>
                                       <td colspan="2" class="text-center">暂无数据</td>
                                   </tr>
                                @endforelse
                                @endif
                           </tbody>
                       </table>
                   </div>
                   <div class="comment" style="display: none">

                       @include('components.frontend.comment_box', ['submitUrl' => route('ajax.course.comment', $course)])

                       @include('components.frontend.comment_list', ['comments' => $comments, 'url' => route('ajax.course.comments', $course)])

                   </div>
               </div>
            </div>

            <div class="col-sm-3 course-show-page-right">

                <div class="card">
                    <div class="card-body">
                        <a href="{{ $course->seeUrl() }}" class="btn btn-outline-primary btn-block">立即学习</a>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">新加入同学</div>
                    <div class="card-body">
                        <ul>
                            @forelse($course->getNewJoinMembersCache() as $member)
                                <li class="student-avatar">
                                    <img class="rounded" src="{{ $member->avatar }}" width="36" height="36">
                                </li>
                            @empty
                                <li>
                                    <p class="text-center lh-30 color-gray">暂无数据</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('js')
    <script src="https://lib.baomitu.com/social-share.js/1.0.16/js/social-share.min.js"></script>
    <script crossorigin="anonymous" integrity="sha384-BlPof9RtjBqeJFskKv3sK3dh4Wk70iKlpIe92FeVN+6qxaGUOUu+mZNpALZ+K7ya" src="https://lib.baomitu.com/highlight.js/9.13.1/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    @include('components.frontend.emoji')
    <script>
        $(function () {
            $('.course-video-tab-item').click(function () {
                $('.course-video-tab-item').removeClass('active');
                $(this).addClass('active');
                $('.tab-content-box .' + $(this).attr('data')).show();
                $('.tab-content-box .' + $(this).attr('data')).siblings().hide();
            });
        });
    </script>
@endsection