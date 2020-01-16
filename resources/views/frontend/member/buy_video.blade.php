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
                            <th>视频</th>
                            <th>价格</th>
                            <th>时间</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($records as $record)
                            @if(!($video = $videos[$record['video_id']] ?? []))
                                @continue
                            @endif
                            <tr class="text-center">
                                <td>
                                    <a href="{{ route('course.show', [$video['course']['id'], $video['course']['slug']]) }}">{{ $video['course']['title'] }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('video.show', [$video['course']['id'], $video['id'], $video['slug']]) }}">{{$video['title']}}</a>
                                </td>
                                <td>
                                    @if($record['charge'] > 0)
                                        <span class="label label-danger">{{ $record['charge'] }} 元</span>
                                    @else
                                        <span class="label label-success">免费</span>
                                    @endif
                                </td>
                                <td>{{$record['created_at']}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center color-gray" colspan="4">暂无数据</td>
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