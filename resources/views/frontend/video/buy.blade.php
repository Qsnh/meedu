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
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <h3 class="text-center">你正在购买视频《{{$video->title}}》</h3>
                <p class="lh-30">所属课程：《{{$video->course->title}}》</p>

                <div style="margin-top: 15px;">
                    <h1 class="text-center">￥{{$video->charge}}</h1>
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