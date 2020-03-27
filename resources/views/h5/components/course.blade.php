<a href="{{route('course.show', [$course['id'], $course['slug']])}}"
   class="banner-course-item {{$index % 2 === 0 ? 'first' : ''}}">
    <div class="course-thumb" style="background-image: url('{{$course['thumb']}}')"></div>
    <div class="course-title">{{$course['title']}}</div>
    <div class="course-info">
        <span class="course-category">{{$course['category']['name']}}</span>
        <span class="course-video-count">{{$course['videos_count']}}课时</span>
    </div>
</a>