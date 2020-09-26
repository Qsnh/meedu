<a href="{{route('course.show', [$course['id'], $course['slug']])}}"
   class="course-list-item {{$class ?? ''}}">
    <div class="course-thumb">
        <img src="{{$course['thumb']}}" width="280" height="210" alt="{{$course['title']}}">
    </div>
    <div class="course-title">
        {{$course['title']}}
    </div>
    <div class="course-category">
        <div class="course-user-count">
            <i class="fa fa-user-o" aria-hidden="true"></i> {{$course['user_count']}}
        </div>
        <div class="course-charge">
            @if($course['is_free'])
                <span class="charge-value free-charge">免费</span>
            @else
                <span class="charge-value"><small>￥</small>{{$course['charge']}}</span>
            @endif
        </div>
    </div>
</a>