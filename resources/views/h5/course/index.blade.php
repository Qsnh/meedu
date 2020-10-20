@extends('layouts.h5-pure')

@section('content')
    <div class="nav-menus">
        <a class="menu-item {{!$scene ? 'active' : ''}}"
           href="{{route('courses')}}?{{query_builder(['category_id', 'scene'], ['scene' => ''])}}">所有课程</a>
        <a class="menu-item {{$scene == 'free' ? 'active' : ''}}"
           href="{{route('courses')}}?{{query_builder(['category_id', 'scene'], ['scene' => 'free'])}}">免费课程</a>
        <a class="menu-item {{$scene == 'recom' ? 'active' : ''}}"
           href="{{route('courses')}}?{{query_builder(['category_id', 'scene'], ['scene' => 'recom'])}}">推荐课程</a>
        <a class="menu-item {{$scene == 'sub' ? 'active' : ''}}"
           href="{{route('courses')}}?{{query_builder(['category_id', 'scene'], ['scene' => 'sub'])}}">订阅最多</a>
    </div>

    <div class="category-box">
        <a href="{{route('courses')}}?{{query_builder(['category_id', 'scene'], ['category_id' => 0])}}"
           class="category-box-item {{!$categoryId ? 'active' : ''}}">不限</a>
        @foreach($courseCategories as $category)
            <a href="{{route('courses')}}?{{query_builder(['category_id', 'scene'], ['category_id' => $category['id']])}}"
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
        {!! str_replace('pagination', 'pagination justify-content-center', $courses->render('pagination::simple-bootstrap-4')) !!}
    </div>

    @include('h5.components.tabbar', ['active' => 'courses'])

@endsection