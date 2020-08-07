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
                @include('frontend.components.course-item', ['course' => $courseItem, 'class' => (($index + 1) % 4 == 0) ? 'last' : ''])
            @endforeach
        </div>
    </div>
</div>