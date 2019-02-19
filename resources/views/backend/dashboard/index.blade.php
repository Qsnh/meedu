@extends('layouts.backend')

@section('body')

    @include('components.breadcrumb', ['name' => '主面板'])

    <div class="row row-cards">
        <div class="col-6 col-sm-4 col-lg-4">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{$todayRegisterUserCount}}</div>
                    <div class="text-muted mb-4">今日注册</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-4">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{$todayPaidNum}}</div>
                    <div class="text-muted mb-4">今日订单</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-4">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">{{$todayPaidSum}}</div>
                    <div class="text-muted mb-4">今日收入</div>
                </div>
            </div>
        </div>
    </div>

@endsection