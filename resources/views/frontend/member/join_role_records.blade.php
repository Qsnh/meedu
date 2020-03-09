@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="w-100 float-left py-4 mt-4 br-8 px-3 bg-fff">
                    <span>当前会员：<b class="fs-24px">{{$user['role'] ? $user['role']['name'] : '免费会员'}}</b></span>
                    <span class="ml-4">到期时间：<b
                                class="fs-24px">{{$user['role'] ? $user['role_expired_at'] : '-'}}</b></span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="invite-user-box">
                    @forelse($records as $record)
                        <div class="invite-user-item">
                            <span class="invite-user-item-nickname">{{$record['role']['name']}}</span>
                            <span class="invite-user-item-date">{{$record['expired_at']}}</span>
                            <span class="invite-user-item-date">{{$record['started_at']}}</span>
                            <span class="invite-user-item-date">￥{{$record['charge']}}</span>
                        </div>
                    @empty
                        @include('frontend.components.none')
                    @endforelse
                </div>
            </div>
            @if($records->total() > $records->perPage())
                <div class="col-12">
                    {!! str_replace('pagination', 'pagination justify-content-center', $records->render()) !!}
                </div>
            @endif
        </div>
    </div>
@endsection