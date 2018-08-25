@extends('layouts.app')

@section('content')

    <div class="container-fluid course-detail-banner">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2 class="color-fff">{{ $course->title }}</h2>
                            <p class="lh-30">{{ $course->short_description }}</p>
                            <p class="lh-30">
                                <span class="label label-default">
                                    更新于 {{ $course->created_at->diffForHumans() }}
                                </span>
                                @if($course->charge)
                                    <span class="label label-danger">{{$course->charge}}元</span>
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
                    <div class="col-sm-4 course-video-tab-item" data="list">课程列表</div>
                    <div class="col-sm-4 course-video-tab-item" data="comment">评论</div>
                </div>
               <div class="tab-content-box">
                   <div class="intro">
                       {!! $course->getDescription() !!}
                   </div>
                   <div class="list" style="display: none">
                       <ul>
                           @foreach($course->getVideos() as $video)
                               <a href="{{ route('video.show', [$course->id, $video->id, $video->slug]) }}">
                                   <li>
                                       <i class="fa fa-play-circle-o" aria-hidden="true"></i> {{ $video->title  }}
                                       <span class="color-gray float-right">{{ $video->updated_at->diffForHumans() }}</span>
                                   </li>
                               </a>
                           @endforeach
                       </ul>
                   </div>
                   <div class="comment" style="display: none">

                       <div class="col-sm-12">
                           <div class="alert alert-warning">
                               <p>1.支持Markdown语法</p>
                               <p>2.支持 @ 某个人，当你 @ TA的时候我们会发站内消息给TA的</p>
                               <p>3.支持拖拽图片到评论框上传</p>
                               <p>4.支持emoji表情</p>
                           </div>
                       </div>

                       <div class="col-sm-12 comment-box">
                           <form action="{{ route('course.comment', $course) }}" method="post" class="form-horizontal">
                               {!! csrf_field() !!}
                               <div class="form-group">
                                   <textarea name="content" class="form-control" rows="3" placeholder="评论内容"></textarea>
                               </div>
                               <div class="form-group text-right">
                                   <button class="btn btn-primary">提交评论</button>
                               </div>
                           </form>
                       </div>

                       <div class="col-sm-12">
                           <table class="comment-list-box">
                               <tbody>
                               @foreach($course->comments as $comment)
                               <tr class="comment-list-item">
                                   <td width="70" class="user-info">
                                       <p><img class="avatar" src="{{$comment->user->avatar}}" width="50" height="50"></p>
                                       <p class="nickname">{{$comment->user->nick_name}}</p>
                                   </td>
                                   <td class="comment-content">
                                       <p>{!! $comment->getContent() !!}</p>
                                       <p class="text-right color-gray">{{$comment->created_at->diffForHumans()}}</p>
                                   </td>
                               </tr>
                               @endforeach
                               </tbody>
                           </table>
                       </div>

                   </div>
               </div>
            </div>

            <div class="col-sm-3 course-show-page-right">
                <div class="col-sm-12 border option">
                    <a href="" class="join-course-btn">立即学习</a>
                </div>

                <div class="col-sm-12 border news-student">
                    <h4>新加入同学</h4>
                </div>

            </div>

        </div>
    </div>

@endsection

@section('js')
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