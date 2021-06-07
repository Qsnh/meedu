@extends('frontend.layouts.app')

@section('content')
    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <div class="bg-white p-5 rounded shadow">
            <h2 class="text-2xl mb-3 text-gray-800 font-medium">{{$a['title']}}</h2>
            <div class="text-sm text-gray-500 pb-3 border-b border-gray-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="ml-1">{{$a['created_at']}}</span>
            </div>
            <div class="text-gray-800 pt-5 leading-loose">
                {!! $a['announcement'] !!}
            </div>
        </div>
    </div>
@endsection