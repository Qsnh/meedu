@extends('layouts.app')

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="col-12">
                    <h2 class="fw-400 mb-4 c-primary">全部视频</h2>
                    <table class="table table-hover">
                        @foreach($videos as $video)
                            <tr>
                                <td>
                                    <a class="w-100" href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                        <span class="float-left"><i class="fa fa-play-circle-o"></i> {{$video['title']}}</span>
                                        <span class="float-right"><i class="fa fa-clock-o"></i> {{duration_humans($video['duration'])}}</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>

                <div class="col-12 mt-3">
                    <div class="float-right">
                        {{$videos->render()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection