@extends('layouts.h5-pure')

@section('content')

    <form action="{{route('search')}}" id="search-form">
        <div class="search-input">
            @csrf
            <a class="back" href="{{route('index')}}">
                <img src="{{asset('/h5/images/icons/back.png')}}" width="24" height="24">
            </a>
            <div class="input">
                <input type="text" name="keywords" value="{{$keywords}}"
                       class="search-input-text"
                       placeholder="请输入搜索内容"
                       required>
            </div>
        </div>
    </form>

    <div class="search-title">
        搜索结果
    </div>

    <div class="box">
        <div class="courses">
            @forelse($data as $item)
                <div class="search-item">
                    <div class="search-item-title">
                        <a href="{{search_item_url($item['resource_type'], $item['resource_id'])}}">
                            [{{__('search.'.$item['resource_type'])}}]
                            {!! str_replace($keywords, '<b>'.$keywords.'</b>', $item['title']) !!}
                        </a>
                    </div>
                    @if($item['short_desc'])
                        <div class="search-item-short-desc">
                            {!! str_replace($keywords, '<b>'.$keywords.'</b>', $item['short_desc']) !!}
                        </div>
                    @endif
                </div>
            @empty
                @include('h5.components.none')
            @endforelse
        </div>
    </div>

@endsection