@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">我的课程</div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="text-center">
                            <tr>
                                <td>课程</td>
                                <td>价格</td>
                                <td>时间</td>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($records as $record)
                                @if(!($course = $courses[$record['course_id']] ?? []))
                                    @continue
                                @endif
                                <tr class="text-center">
                                    <td>
                                        <a href="{{ route('course.show', [$course['id'], $course['slug']]) }}">{{ $course['title'] }}</a>
                                    </td>
                                    <td>
                                        <span class="label label-danger">{{ $record['charge'] }} 元</span>
                                    </td>
                                    <td>{{$record['created_at']}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center color-gray" colspan="3">暂无数据</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 pt-10">
                <div class="text-right">
                    {{$records->render()}}
                </div>
            </div>
        </div>
    </div>

@endsection