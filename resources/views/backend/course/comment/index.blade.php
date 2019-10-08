@extends('layouts.backend')

@section('title')
    课程评论
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
                            <a href="{{route('course.show', [$comment->course_id, $comment->course->slug])}}">
                                <b>{{$comment->course->title}}</b>
                            </a>
                        </td>
                        <TD>{!! $comment->getContent() !!}</TD>
                        <td>{{$comment->created_at}}</td>
                        <td>
                            @include('components.backend.destroy', ['url' => route('backend.course.comment.destroy', $comment)])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="6">暂无记录</td>
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