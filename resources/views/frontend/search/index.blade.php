@extends('layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12 recom-courses-title">
                <span>搜索结果 <small>只展示最近20条数据</small></span>
            </div>
            <div class="col-12 course-list-box">
                @forelse($courses as $index => $courseItem)
                    <a href="{{route('course.show', [$courseItem['id'], $courseItem['slug']])}}"
                       class="course-list-item {{(($index + 1) % 4 === 0) ? 'last' : ''}}">
                        <div class="course-thumb">
                            <img src="{{$courseItem['thumb']}}" width="280" height="210" alt="{{$courseItem['title']}}">
                        </div>
                        <div class="course-title">
                            {{$courseItem['title']}}
                        </div>
                        <div class="course-category">
                            <span class="video-count-label">课时：{{$courseItem['videos_count']}}节</span>
                            <span class="category-label">{{$courseItem['category']['name']}}</span>
                        </div>
                    </a>
                @empty
                    @include('frontend.components.none')
                @endforelse
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection