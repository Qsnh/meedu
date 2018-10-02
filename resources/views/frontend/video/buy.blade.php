@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>购买视频</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-buy-box">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">你正在购买视频《{{$video->title}}》</h3>
                <p class="lh-30">课程：《{{$video->course->title}}》</p>
                <p class="lh-30">价格：<b>￥{{$video->charge}}</b></p>
                <p class="lh-30">当前账户余额：<b>￥{{$user->credit1}}</b></p>

                @if($user->credit1 < $video->charge)
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