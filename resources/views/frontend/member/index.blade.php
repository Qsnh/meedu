@extends('layouts.member')

@section('content')
    @if($announcement)
        <div class="row">
            <div class="alert alert-warning">
                <p><b>公告：</b></p>
                {!! $announcement->getAnnouncementContent() !!}
                <p class="text-right">{{$announcement->updated_at}}</p>
                @if($announcement->administrator)
                    <p class="text-right">来自：{{$announcement->administrator->name}}</p>
                @endif
            </div>
        </div>
    @endif
@endsection