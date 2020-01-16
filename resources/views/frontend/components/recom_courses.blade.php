<div class="container-fluid bg-fff">
    <div class="row">
        <div class="col-12">
            <div class="container my-5">
                <div class="row">
                    <div class="col-12">
                        <h2 class="fw-400 mb-4 c-primary">最新课程</h2>
                        <div class="row">
                            @foreach($gLatestCourses as $index => $courseItem)
                                @if($index == 4)
                                    @break
                                @endif
                                <div class="col-12 col-md-3 pb-24px video-item">
                                    <a href="{{route('course.show', [$courseItem['id'], $courseItem['slug']])}}">
                                        <div class="video-item-box box-shadow1 br-8 t1 float-left">
                                            <div class="video-thumb">
                                                <div class="video-thumb-img"
                                                     style="background: url('{{$courseItem['thumb']}}') center center no-repeat;background-size: cover;">
                                                </div>
                                            </div>
                                            <div class="video-title py-3 float-left">
                                                <span>{{$courseItem['title']}}</span>
                                            </div>
                                            <div class="video-extra pb-3">
                                                <span class="float-left"><i class="fa fa-file-video-o"></i> {{$courseItem['videos_count']}}</span>
                                                <span class="float-right">
                                                        @if($courseItem['category'])
                                                        <i class="fa fa-tag"></i> {{$courseItem['category']['name']}}
                                                    @endif
                                                    </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>