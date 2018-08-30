@extends('layouts.member')

@section('content')
    <ul class="notifications">
        @forelse($messages as $message)
            <li class="{{ $message->read_at ? 'color-orange' : '' }}">
                @include('frontend.member.notifications.' . notification_name($message->type), ['notification' => $message])
            </li>
            @if($message->markAsRead())@endif
        @empty
            <li>
                <p class="text-center lh-30 color-gray">暂无数据</p>
            </li>
        @endforelse
    </ul>
    <div class="text-right">
        {{$messages->render()}}
    </div>
@endsection