@extends('frontend.layouts.member')

@section('member')

    @if($messages->isNotEmpty())
        <div class="mb-3 text-right">
            <a href="javascript:void(0)" data-url="{{route('ajax.message.read.all')}}"
               data-message-success="{{__('成功')}}"
               class="btn-read-all-message text-gray-500 hover:text-gray-600 text-sm">全部已读</a>
        </div>
        @foreach($messages as $messageItem)
            <div class="bg-white p-5 mb-5 rounded shadow message-item cursor-pointer"
                 data-url="{{route('ajax.message.read')}}" data-id="{{$messageItem['id']}}">
                <div class="message-item-content flex items-center {{$messageItem['read_at'] ? 'text-gray-500' : 'text-gray-800'}}">
                    <div class="mr-3 dot">
                        @if($messageItem['read_at'])
                            <div class="w-2 h-2 rounded-full bg-white"></div>
                        @else
                            <div class="w-2 h-2 rounded-full bg-red-500"></div>
                        @endif
                    </div>
                    <div class="flex-1 text-sm">
                        {!! $messageItem['data']['message'] !!}
                    </div>
                    <div class="ml-3 text-xs text-gray-400">
                        {{$messageItem['created_at']}}
                    </div>
                </div>
            </div>
        @endforeach
    @else
        @include('frontend.components.none')
    @endif

    <div>
        {{$messages->render('frontend.components.common.paginator')}}
    </div>

@endsection