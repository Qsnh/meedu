@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="member-message-box">
                    @forelse($messages as $message)
                        <div class="member-message-item" data-id="{{$message['id']}}">
                            @if(!$message['read_at'])
                                <div class="red-dot"></div>
                            @endif

                            <img src="/images/icons/message.png" width="24" height="24">
                            <span class="message-content">{!! $message['data']['message'] !!}</span>

                            @if($message['read_at'])
                                <span class="member-message-read">已读</span>
                            @else
                                <span class="member-message-unread">未读</span>
                            @endif

                            <span class="member-message-date">{{\Carbon\Carbon::parse($message['created_at'])->format('Y-m-d H:i')}}</span>
                        </div>
                    @empty
                        @include('frontend.components.none')
                    @endforelse
                </div>
            </div>

            @if($messages->total() > $messages->perPage())
                <div class="col-md-12">
                    {!! str_replace('pagination', 'pagination justify-content-center', $messages->render()) !!}
                </div>
            @endif
        </div>
    </div>

@endsection