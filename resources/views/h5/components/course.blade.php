<a href="{{route('course.show', [$course['id'], $course['slug']])}}"
   class="banner-course-item">
    <div class="course-thumb" style="background-image: url('{{$course['thumb']}}')"></div>
    <div class="course-title">{{$course['title']}}</div>
    <div class="course-info">
        <div class="course-user-count">{{$course['user_count']}}订阅</div>
        <div class="course-charge">
            <span class="charge-value"><small>￥</small>{{$course['charge']}}</span>
        </div>
    </div>
</a>