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
            <div class="col-sm-8">
                <h3 class="text-center">你正在购买课程《{{$course->title}}》</h3>
                <ul class="list-group">
                    @foreach($course->videos as $video)
                    <li class="list-group-item">
                        <a href="{{route('video.show', [$course->id, $video->id, $video->slug])}}">{{$video->title}}</a>
                    </li>
                    @endforeach
                </ul>

                <p class="lh-30">价格：<b>￥{{$course->charge}}</b></p>
                <p class="lh-30">当前账户余额：<b>￥{{$user->credit1}}</b></p>

                @if($user->credit1 < $course->charge)
                    @include('components.frontend.insufficient')
                @else
                    <form action="" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">立即购买</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

@endsection