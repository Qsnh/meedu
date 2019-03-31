@extends('layouts.member')

@section('member')

    @if($announcement)
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <h4 class="card-title">网站公告</h4>
                    <div class="card-body">
                        {!! $announcement->getAnnouncementContent() !!}
                        <p class="text-right">{{$announcement->updated_at}}</p>
                    </div>
                    <div class="card-footer text-right">
                        {{$announcement->administrator->name}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection