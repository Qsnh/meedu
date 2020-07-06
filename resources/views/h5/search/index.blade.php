@extends('layouts.h5-pure')

@section('content')

    <form action="{{route('search')}}" id="search-form">
        <div class="search-input">
            @csrf
            <a class="back" href="{{route('index')}}">
                <img src="{{asset('/h5/images/icons/back.png')}}" width="24" height="24">
            </a>
            <div class="input">
                <input type="text" name="keywords" value="{{request()->input('keywords')}}"
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
            @forelse($courses as $index => $course)
                @include('h5.components.course', ['course' => $course])
            @empty
                @include('h5.components.none')
            @endforelse
        </div>
    </div>

@endsection