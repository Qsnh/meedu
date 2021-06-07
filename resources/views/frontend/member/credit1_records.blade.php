@extends('frontend.layouts.member')

@section('member')

    @forelse($records as $recordItem)
        <div class="bg-white mb-5 px-5 py-3 shadow rounded">
            <div class="flex items-center text-gray-500">
                <div class="flex-1">
                    <div class="mb-3 text-sm">
                        {{$recordItem['remark']}}
                    </div>
                    <div>
                        @if($recordItem['sum'] > 0)
                            <span class="text-gray-700 font-medium">+{{$recordItem['sum']}}</span>
                        @else
                            <span class="text-red-500 font-medium">{{$recordItem['sum']}}</span>
                        @endif
                    </div>
                </div>
                <div class="text-gray-400 text-xs">
                    {{$recordItem['created_at']}}
                </div>
            </div>
        </div>
    @empty
        @include('frontend.components.none')
    @endforelse

    <div>
        {{$records->render('frontend.components.common.paginator')}}
    </div>

@endsection