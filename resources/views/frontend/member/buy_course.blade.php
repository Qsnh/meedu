@extends('layouts.member')

@section('member')

    <div class="row">
        <h3>已购课程</h3>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <td>课程</td>
            <td>价格</td>
            <td>时间</td>
        </tr>
        </thead>
        <tbody>
        @forelse($courses as $course)
            <tr>
                <td><a href="{{ route('course.show', [$course->id, $course->slug]) }}">{{ $course->title }}</a></td>
                <td>
                    @if($course->pivot->charge > 0)
                        <span class="label label-danger">{{ $course->pivot->charge }} 元</span>
                        @else
                        <span class="label label-success">免费</span>
                    @endif
                </td>
                <td>{{$course->pivot->created_at}}</td>
            </tr>
            @empty
            <tr>
                <td class="text-center color-gray" colspan="3">暂无数据</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="text-right">
        {{$courses->render()}}
    </div>
@endsection