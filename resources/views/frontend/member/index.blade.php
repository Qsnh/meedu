@extends('layouts.member')

@section('member')

    <div class="row">
        @if($announcement)
            <div class="col-sm-12">
                <div class="alert alert-warning announcement">
                    <p><b>公告：</b></p>
                    {!! $announcement->getAnnouncementContent() !!}
                    <p class="text-right">{{$announcement->updated_at}}</p>
                    @if($announcement->administrator)
                        <p class="text-right">来自：{{$announcement->administrator->name}}</p>
                    @endif
                </div>
            </div>
        @endif
        <div class="col-sm-12">
            <h3>最近学习</h3>
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>视频</td>
                    <td>时间</td>
                </tr>
                </thead>
                <tbody>
                @forelse($videos as $video)
                    <tr>
                        <td>
                            <a href="{{route('video.show', [$video->course->id, $video->id, $video->slug])}}">
                                {{$video->title}}
                            </a>
                        </td>
                        <td>{{$video->pivot->created_at}}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="2">暂无记录</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection