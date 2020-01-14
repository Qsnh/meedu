@extends('layouts.app')

@section('css')
    <style>
        body {
            background-color: #f6f6f6;
        }
    </style>
@endsection

@section('content')

    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="col-12">
                    <h2 class="fw-400 mb-4 c-primary">搜索结果 <small class="fs-14px c-2">只显示最近的20条数据</small></h2>
                    <table class="table table-hover">
                        @foreach($videos as $video)
                            <tr>
                                <td>
                                    <a class="d-inline-block w-100 float-left" href="{{route('video.show', [$video['course_id'], $video['id'], $video['slug']])}}">
                                        <span class="float-left"><i class="fa fa-play-circle-o"></i> {{$video['title']}}</span>
                                        <span class="float-right"><i class="fa fa-clock-o"></i> {{duration_humans($video['duration'])}}</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection