@extends('layouts.app')

@section('content')

    <div class="container-fluid course-detail-banner">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h2>{{ $course->title }}</h2>
                            <p>{{ $course->short_description }}</p>
                            <p>
                                <span class="label label-default">
                                    更新于 {{ $course->created_at->diffForHumans() }}
                                </span>
                                @if($course->charge)
                                    <span class="label label-default">{{$course->charge}}元</span>
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