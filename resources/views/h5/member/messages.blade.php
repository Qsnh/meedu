@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '我的消息', 'back' => route('member')])

    <div class="member-messages-page">

        @forelse($messages as $message)
            <div class="member-message-item {{$message['read_at'] ?'':'unread'}}" data-id="{{$message['id']}}">
                <div class="date">{{$message['created_at']}}</div>
                <div class="content">{!! $message['data']['message'] !!}</div>
            </div>
        @empty
            @include('h5.components.none')
        @endforelse

        @if($messages->total() > $messages->perPage())
            <div class="box">
                {!! str_replace('pagination', 'pagination justify-content-center', $messages->render('pagination::simple-bootstrap-4')) !!}
            </div>
        @endif
    </div>



@endsection