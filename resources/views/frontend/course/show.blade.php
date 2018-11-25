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
                       <table style="width: 100%">
                           <tbody>
                           @forelse($course->getAllPublishedAndShowVideosCache() as $video)
                               <tr style="line-height: 36px;">
                                   <td>
                                       <a href="{{ route('video.show', [$course->id, $video->id, $video->slug]) }}">
                                           <i class="fa fa-play-circle-o" aria-hidden="true"></i>
                                           @if($video->charge > 0)
                                           <span class="badge badge-danger">收费</span>
                                               @else
                                            <span class="badge badge-success">免费</span>
                                           @endif
                                           {{ $video->title  }}
                                       </a>
                                   </td>
                                   <td width="80" class="text-right color-gray">{{ $video->updated_at->diffForHumans() }}</td>
                               </tr>
                           @empty
                               <tr>
                                   <td colspan="2" class="text-center">暂无数据</td>
                               </tr>
                           @endforelse
                           </tbody>
                       </table>
                   </div>
                   <div class="comment" style="display: none">

                       @include('components.frontend.comment_box', ['submitUrl' => route('course.comment', $course)])

                       <div class="col-sm-12">
                           <table class="comment-list-box">
                               <tbody>
                               @forelse($course->comments as $comment)
                               <tr class="comment-list-item">
                                   <td width="70" class="user-info">
                                       <p><img class="avatar" src="{{$comment->user->avatar}}" width="50" height="50"></p>
                                       <p class="nickname">
                                           {{$comment->user->nick_name}}
                                       </p>
                                       @if($comment->user->role)
                                           <span class="badge badge-danger nickname">{{$comment->user->role->name}}</span>
                                       @endif
                                   </td>
                                   <td class="comment-content">
                                       <p>{!! $comment->getContent() !!}</p>
                                       <p class="text-right color-gray">{{$comment->created_at->diffForHumans()}}</p>
                                   </td>
                               </tr>
                               @empty
                               <tr>
                                   <td class="text-center color-gray" colspan="2">0评论</td>
                               </tr>
                               @endforelse
                               </tbody>
                           </table>
                       </div>

                   </div>
               </div>
            </div>

            <div class="col-sm-3 course-show-page-right">
                <div class="col-sm-12 border option">
                    <a href="{{ $course->seeUrl() }}" class="join-course-btn">立即学习</a>
                </div>

                <div class="col-sm-12 border news-student">
                    <h6 class="lh-30">新加入同学</h6>
                    <ul>
                        @forelse($course->getNewJoinMembersCache() as $member)
                            <li>
                                <img src="{{ $member->avatar }}" width="24" height="24">
                                <b>{{ $member->nick_name }}</b>
                                <span class="color-gray font-size-12">{{$member->pivot->created_at}}</span>
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

@endsection

@section('js')
    <script src="https://lib.baomitu.com/social-share.js/1.0.16/js/social-share.min.js"></script>
    <script crossorigin="anonymous" integrity="sha384-BlPof9RtjBqeJFskKv3sK3dh4Wk70iKlpIe92FeVN+6qxaGUOUu+mZNpALZ+K7ya" src="https://lib.baomitu.com/highlight.js/9.13.1/highlight.min.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    @include('components.frontend.emoji')
    @include('components.frontend.comment_js')
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