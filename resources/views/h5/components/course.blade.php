<a href="{{route('course.show', [$course['id'], $course['slug']])}}"
   class="banner-course-item">
    <div class="course-thumb">
        <img src="{{$course['thumb']}}" width="100%">
    </div>
    <div class="course-title">{{$course['title']}}</div>
    <div class="course-info">
        <div class="course-user-count">{{$course['user_count']}}订阅</div>
        <div class="course-charge">
            @if($course['is_free'])
                <span class="charge-value free-charge">免费</span>
            @else
                <span class="charge-value"><small>￥</small>{{$course['charge']}}</span>
            @endif
        </div>
    </div>
</a>