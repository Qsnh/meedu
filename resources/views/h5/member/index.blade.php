@extends('layouts.h5')

@section('content')

    <div class="container-fluid bg-fff">
        <div class="row">
            <div class="col-12">
                <div class="user-avatar">
                    <img src="{{$user['avatar']}}" width="80" height="80">
                </div>
                <div class="user-nickname">
                    {{$user['nick_name']}}
                    @if($user['role_id'] && \Carbon\Carbon::parse($user['role_expired_at'])->gt(\Carbon\Carbon::now()))
                        <small>{{$user['role']['name']}}</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-fff my-5 py-3">
        <div class="row">
            <div class="col-12">
                <div class="user-menu-box">
                    <a href="{{route('member.courses')}}" class="user-menu-item">
                        <img src="/h5/images/icons/course.png" width="20" height="20">
                        <span class="title">我的课程</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('h5.components.navbar')

@endsection