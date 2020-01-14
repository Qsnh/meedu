@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-md-12 py-4">
                共{{$records->total()}}条记录
            </div>
            <div class="col-md-12 mb-4">
                <div class="w-100 float-left bg-fff px-3 pt-5 br-8">
                    <table class="table">
                        <thead class="text-center">
                        <tr>
                            <th>课程</th>
                            <th>价格</th>
                            <th>时间</th>
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

            @if($records->total() > $records->perPage())
                <div class="col-md-12">
                    <div class="w-100 float-left bg-fff mb-4 br-8 px-3 py-4">
                        {{$records->render()}}
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection