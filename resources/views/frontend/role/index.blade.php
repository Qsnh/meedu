@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 py-32 lg:max-w-6xl lg:mx-auto">
        <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:max-w-7xl lg:grid-cols-3">
            @foreach($gRoles as $index => $roleItem)
                <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900">{{$roleItem['name']}}</h3>

                        @if($index === 1)
                            <p class="absolute top-0 py-1.5 px-4 bg-blue-500 rounded-full text-xs font-semibold uppercase tracking-wide text-white transform -translate-y-1/2">
                                {{__('推荐')}}</p>
                        @endif

                        <p class="mt-4 flex items-baseline text-gray-900">
                            <span class="text-5xl font-extrabold tracking-tight">{{__('￥')}}{{$roleItem['charge']}}</span>
                            <span class="ml-1 text-xl font-semibold">/{{$roleItem['expire_days']}}{{__('天')}}</span>
                        </p>

                        <ul role="list" class="mt-6 space-y-6">
                            @foreach($roleItem['desc_rows'] as $item)
                                <li class="flex">
                                    <svg class="flex-shrink-0 w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span class="ml-3 text-gray-500">{{$item}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <a href="{{route('member.role.buy', [$roleItem['id']])}}"
                       class="{{$index === 1 ? 'bg-blue-500 text-white hover:bg-blue-600' : 'bg-blue-50 text-blue-700 hover:bg-blue-100'}} mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium">
                        {{__('购买')}}
                    </a>
                </div>

            @endforeach
        </div>
    </div>

@endsection