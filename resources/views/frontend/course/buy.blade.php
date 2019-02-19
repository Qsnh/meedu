@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>购买课程</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <h3 style="line-height: 100px;" class="text-center">你正在购买课程《{{$course->title}}》</h3>
                <ul class="list-group">
                    <p>视频如下</p>
                    @foreach($course->videos as $video)
                    <li class="list-group-item">
                        <a href="{{route('video.show', [$course->id, $video->id, $video->slug])}}">{{$video->title}}</a>
                    </li>
                    @endforeach
                </ul>

                <div style="margin-top: 15px;">
                    <h1 class="text-center">￥{{$course->charge}}</h1>
                    <form action="" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">立即购买</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection