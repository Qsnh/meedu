<div class="container" style="margin-top: 80px;">
    <div class="row">
        <div class="col-12 recom-courses-title">
            <span>推荐课程</span>
        </div>
        <div class="col-12 course-list-box">
            @foreach($gRecCourses as $index => $courseItem)
                @if($index == 4)
                    @break
                @endif
                <a href="{{route('course.show', [$courseItem['id'], $courseItem['slug']])}}"
                   class="course-list-item {{(($index + 1) % 4 == 0) ? 'last' : ''}}">
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
            @endforeach
        </div>
    </div>
</div>