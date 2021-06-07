@extends('frontend.layouts.member')

@section('member')

    @forelse($records as $recordItem)
        @continue(!$recordItem['role'])
        <div class="bg-white p-5 shadow rounded mb-5">
            <div class="flex items-center text-sm text-gray-500">
                <div class="flex-1">
                    <div class="font-medium text-xl mb-3 text-gray-800">
                        {{$recordItem['role']['name']}}
                    </div>
                    <div class="text-gray-400 text-xs">
                        <span>{{$recordItem['started_at']}}</span>
                        <span class="text-gray-300">-</span>
                        <span>{{$recordItem['expired_at']}}</span>
                    </div>
                </div>
                <div class="ml-3">
                    <span class="text-red-500 text-xl font-medium"><small>{{__('￥')}}</small>{{ $recordItem['charge'] }}</span>
                </div>
            </div>
        </div>
    @empty
        @include('frontend.components.none')
    @endforelse

    <div class="">
        {{$records->render('frontend.components.common.paginator')}}
    </div>

@endsection