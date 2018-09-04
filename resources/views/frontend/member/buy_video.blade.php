@extends('layouts.member')

@section('content')

    <table class="table table-hover">
        <thead>
        <tr>
            <td>课程</td>
            <td>视频</td>
            <td>价格</td>
            <td>时间</td>
        </tr>
        </thead>
        <tbody>
        @forelse($videos as $video)
            <tr>
                <td><a href="{{ route('course.show', [$video->course->id, $video->course->slug]) }}">{{ $video->course->title }}</a></td>
                <td>
                    <a href="{{ route('video.show', [$video->course->id, $video->id, $video->slug]) }}">{{$video->title}}</a>
                </td>
                <td>
                    @if($video->pivot->charge > 0)
                        <span class="label label-danger">{{ $video->pivot->charge }} 元</span>
                    @else
                        <span class="label label-success">免费</span>
                    @endif
                </td>
                <td>{{$video->pivot->created_at}}</td>
            </tr>
        @empty
            <tr>
                <td class="text-center color-gray" colspan="4">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-right">
        {{$videos->render()}}
    </div>
@endsection