@extends('frontend.layouts.app')

@section('content')

    <div class="w-full bg-white">
        <div class="pt-6 pb-2">
            <div class="w-full px-3 lg:max-w-6xl lg:mx-auto">
                <a href="javascript:void(0)"
                   class="inline-block text-gray-500 py-2 mr-10 mb-4 text-sm">{{__('分类')}}</a>
                <a href="?category_id=0"
                   class="inline-block {{$categoryId === 0 ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-800'}} px-2 py-1 mr-4 mb-4 text-sm rounded-md">{{__('全部')}}</a>
                @foreach($courseCategories as $item)
                    <a href="?category_id={{$item['id']}}"
                       class="inline-block {{$categoryId === $item['id'] ? 'bg-blue-100 text-blue-600 font-medium' : 'text-gray-800'}} px-2 py-1 mr-4 mb-4 text-sm rounded-md">{{$item['name']}}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <div class="mb-6">
            <a href="?category_id={{$categoryId}}&scene={{$scene === 'free' ? '' : 'free'}}"
               class="mr-3 text-sm rounded px-2 py-1 {{$scene === 'free' ? 'bg-gray-800 text-white' : 'text-gray-500'}}">{{__('免费')}}</a>
            <a href="?category_id={{$categoryId}}&scene={{$scene === 'sub' ? '' : 'sub'}}"
               class="mr-3 text-sm rounded px-2 py-1  {{$scene === 'sub' ? 'bg-gray-800 text-white' : 'text-gray-500'}}">{{__('热门')}}</a>
            <a href="?category_id={{$categoryId}}&scene={{$scene === 'recom' ? '' : 'recom'}}"
               class="mr-3 text-sm rounded px-2 py-1  {{$scene === 'recom' ? 'bg-gray-800 text-white' : 'text-gray-500'}}">{{__('推荐')}}</a>
        </div>
        @if($courses->isNotEmpty())
            <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($courses as $courseItem)
                    @include('frontend.components.course-item', ['course' => $courseItem])
                @endforeach
            </div>
        @else
            <div>
                @include('frontend.components.none')
            </div>
        @endif
        <div class="mt-10">
            {{$courses->render('frontend.components.common.paginator')}}
        </div>
    </div>

@endsection