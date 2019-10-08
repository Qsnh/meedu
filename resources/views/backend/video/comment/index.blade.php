@extends('layouts.backend')

@section('title')
    视频评论
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>用户</th>
                    <th>课程</th>
                    <th>视频</th>
                    <th>内容</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td>{{$comment->id}}</td>
                        <td>{{$comment->user->nick_name}}</td>
                        <td>
                            <a href="{{route('course.show', [$comment->video->course_id, $comment->video->course->slug])}}" target="_blank">
                                <b>{{$comment->video->course->title}}</b>
                            </a>
                        </td>
                        <td>
                            <a target="_blank" href="{{route('video.show', [$comment->video->course_id, $comment->video->id, $comment->video->slug])}}">
                                <b>{{$comment->video->title}}</b>
                            </a>
                        </td>
                        <TD>{!! $comment->getContent() !!}</TD>
                        <td>{{$comment->created_at}}</td>
                        <td>
                            @include('components.backend.destroy', ['url' => route('backend.video.comment.destroy', $comment)])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="7">暂无记录</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-sm-12">
            {{$comments->render()}}
        </div>
    </div>

@endsection