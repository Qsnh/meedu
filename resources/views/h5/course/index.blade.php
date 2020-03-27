@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '所有课程', 'back' => route('index'), 'class' => 'primary'])

    <div class="courses-menu">
        <div class="menu-item {{!$scene ? 'active' : ''}}">
            <a href="{{route('courses')}}?{{$queryParams(['scene' => ''])}}">所有课程</a>
        </div>
        <div class="menu-item {{$scene == 'recom' ? 'active' : ''}}">
            <a href="{{route('courses')}}?{{$queryParams(['scene' => 'recom'])}}">推荐课程</a>
        </div>
        <div class="menu-item {{$scene == 'sub' ? 'active' : ''}}">
            <a href="{{route('courses')}}?{{$queryParams(['scene' => 'sub'])}}">订阅最多</a>
        </div>
    </div>

    <div class="category-box">
        <a href="{{route('courses')}}?{{$queryParams(['category_id' => 0])}}"
           class="category-box-item {{!$categoryId ? 'active' : ''}}">不限</a>
        @foreach($courseCategories as $category)
            <a href="{{route('courses')}}?{{$queryParams(['category_id' => $category['id']])}}"
               class="category-box-item {{$categoryId == $category['id'] ? 'active' : ''}}">{{$category['name']}}</a>
        @endforeach
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

    <div class="box">
        {!! str_replace('pagination', 'pagination justify-content-center', $courses->render()) !!}
    </div>

@endsection