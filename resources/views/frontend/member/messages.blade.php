@extends('layouts.member')

@section('member')

    <div class="row">
        <h3>我的消息</h3>
    </div>

    <ul class="notifications">
        @forelse($messages as $message)
            <li class="{{ $message->read_at ? 'color-orange' : '' }}">
                {!! (new \App\Meedu\NotificationParse())->parseHTML($message) !!}
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