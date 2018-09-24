@extends('layouts.app')

@section('css')
    <link href="https://cdn.bootcss.com/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
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
                                <span class="label label-default">
                                    更新于 {{ $course->created_at->diffForHumans() }}
                                </span>
                                @if($course->charge)
                                    <span class="label label-danger">价格 {{$course->charge}}元</span>
                                @else
                                    <span class="label label-success">免费</span>
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
                    <div class="col-sm-4 course-video-tab-item active" data="intro">简介</div>
                    <div class="col-sm-4 course-video-tab-item" data="list">视频列表</div>
                    <div class="col-sm-4 course-video-tab-item" data="comment">评论</div>
                </div>
               <div class="tab-content-box">
                   <div class="intro">
                       <p class="lh-30">{{ $course->short_description }}</p>
                       <hr>
                       {!! $course->getDescription() !!}
                       <hr>
                       <div class="social-share"></div>
                   </div>
                   <div class="list" style="display: none">
                       <ul>
                           @forelse($course->getVideos() as $video)
                               <a href="{{ route('video.show', [$course->id, $video->id, $video->slug]) }}">
                                   <li>
                                       <i class="fa fa-play-circle-o" aria-hidden="true"></i> {{ $video->title  }}
                                       <span class="color-gray float-right">{{ $video->updated_at->diffForHumans() }}</span>
                                   </li>
                               </a>
                           @empty
                            <p class="text-center color-gray lh-30">暂无视频</p>
                           @endforelse
                       </ul>
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
                                           <p class="nickname">{{$comment->user->role->name}}</p>
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
                    <h4>新加入同学</h4>
                    <ul>
                        @forelse($newJoinMembers as $member)
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
    <script src="https://cdn.bootcss.com/social-share.js/1.0.16/js/social-share.min.js"></script>
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