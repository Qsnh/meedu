@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 py-6 lg:max-w-6xl lg:mx-auto">
        <div class="w-full py-10">
            <form action="" method="get">
                <div class="flex">
                    <div class="flex-1">
                        <input type="text" name="keywords"
                               placeholder="{{__('请输入搜索关键字')}}"
                               autocomplete="off"
                               value="{{$keywords}}"
                               class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white"
                               required>
                    </div>
                    <div class="pl-5">
                        <button type="submit"
                                class="w-24 rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                            {{__('搜索')}}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="w-full mb-5">
            <span class="text-sm text-gray-600">{{__('搜索结果')}}</span>
        </div>
        <div class="w-full">
            @if($data->isNotEmpty())
                @foreach($data as $item)
                    <div class="w-full mb-5">
                        <div>
                            <a href="{{search_item_url($item['resource_type'], $item['resource_id'])}}"
                               class="text-gray-600 hover:text-blue-700">
                                [{{__('search.'.$item['resource_type'])}}]
                                {!! str_replace($keywords, '<b class="text-red-500">'.$keywords.'</b>', $item['title']) !!}
                            </a>
                        </div>
                        @if($item['short_desc'])
                            <div class="pt-2 text-sm text-gray-500">
                                {!! str_replace($keywords, '<b class="text-red-500">'.$keywords.'</b>', $item['short_desc']) !!}
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                @include('frontend.components.none')
            @endif
        </div>
    </div>

    <div class="mt-10">
        {{$data->render('frontend.components.common.paginator')}}
    </div>

@endsection