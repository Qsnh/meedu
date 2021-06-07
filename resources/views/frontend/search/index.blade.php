@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <div class="text-gray-500 text-sm mb-6">
            {{__('搜索结果只展示最近20条数据')}}
        </div>
        <div>
            @if($courses)
                <div class="grid gap-6 grid-cols-1 lg:grid-cols-4">
                    @foreach($courses as $index => $courseItem)
                        @include('frontend.components.course-item', ['course' => $courseItem])
                    @endforeach
                </div>
            @else
                @include('frontend.components.none')
            @endif
        </div>
    </div>

@endsection