@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 mt-20 mb-20 lg:max-w-6xl lg:mx-auto">
        <div class="flex justify-center">
            <div class="w-full lg:w-96">
                <div class="bg-white rounded p-5 shadow">
                    <div class="text-2xl font-bold text-gray-800 mb-2 text-center mt-5">{{__('微信账号绑定')}}</div>
                    <div class="text-gray-500 text-sm text-center mb-5">{{__('请使用微信扫码下方二维码')}}</div>
                    <div class="mb-5 text-center">
                        <img src="{{$image}}" class="inline object-cover" width="300" height="300">
                    </div>
                    <div class="px-10">
                        <a href="{{route('member')}}"
                           class="block w-full mb-3 rounded px-5 py-3 bg-blue-600 text-white text-base hover:bg-blue-500 flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span class="ml-1">{{__('已绑定')}}</span>
                        </a>
                        <a href="{{route('member')}}"
                           class="block w-full rounded text-gray-500 text-center text-base hover:text-gray-800">{{__('取消')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection