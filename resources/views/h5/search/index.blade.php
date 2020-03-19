@extends('layouts.h5-pure')

@section('content')

    <form action="{{route('search')}}" id="search-form">
        <div class="search-input">
            @csrf
            <a class="back" href="{{route('index')}}">
                <img src="{{asset('/h5/images/icons/back.png')}}" width="24" height="24">
            </a>
            <div class="input">
                <input type="text" name="keywords" value="{{request()->input('keywords')}}" class="search-input-text" required>
            </div>
        </div>
    </form>

    <div class="search-title">
        搜索结果
    </div>

    <div class="box">
        <div class="courses">
            @forelse($courses as $index => $course)
                <a href="{{route('course.show', [$course['id'], $course['slug']])}}" class="banner-course-item {{$index % 2 === 0 ? 'first' : ''}}">
                    <div class="course-thumb" style="background-image: url('{{$course['thumb']}}')"></div>
                    <div class="course-title">{{$course['title']}}</div>
                    <div class="course-info">
                        <span class="course-category">{{$course['category']['name']}}</span>
                        <span class="course-video-count">{{$course['videos_count']}}课时</span>
                    </div>
                </a>
            @empty
                @include('h5.components.none')
            @endforelse
        </div>
    </div>

@endsection