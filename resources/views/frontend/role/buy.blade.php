@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>订阅计划</strong>
            </h1>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card b-1 border-light card-round">
                    <header class="bg-lightest bb-1 px-40 py-60">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-left">
                                <img src="/frontend/logo.png" alt="logo">
                            </div>
                            <div class="col-md-6 text-center text-md-right">
                            </div>
                        </div>
                    </header>
                    <div>
                        <div class="media-list media-list-divided bb-1 border-light">
                            <div class="media align-items-center p-40">
                                <div class="media-body">
                                    <h4>{{$role['name']}}</h4>
                                    @foreach(explode("\n", $role['description']) as $row)
                                        <p class="text-muted">{{$row}}</p>
                                    @endforeach
                                </div>
                                <h4 class="text-primary fw-500">￥{{$role['charge']}}</h4>
                            </div>
                        </div>
                        <br><br>
                        <div class="p-40 text-right">
                            <div>
                                <small class="text-uppercase text-muted">总价</small>
                                <span class="w-150px d-inline-block fw-400">￥{{$role['charge']}}</span>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted">折扣</small>
                                <span class="w-150px d-inline-block fw-400">-￥0</span>
                            </div>

                            <hr class="hr-sm w-50 mr-0">

                            <h4 class="text-uppercase">
                                <strong class="fs-14">总计</strong>
                                <div class="w-150px d-inline-block text-primary">
                                    <span class="fw-500 fs-20">￥{{$role['charge']}}</span>
                                    <span class="fs-10 fw-300 opacity-70">CNY</span>
                                </div>
                            </h4>
                        </div>
                    </div>
                    <footer class="bg-lightest bt-1 p-40">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="text-muted text-uppercase mb-1">注意</h5>
                                <p class="text-muted">
                                    由于视频的特殊性质，购买之后无法退款，请慎重决定是否购买。
                                </p>
                            </div>
                        </div>
                    </footer>

                    <form action="" method="post">
                        @csrf
                        <button type="submit" class="btn btn-block btn-bold btn-lg btn-primary no-radius">现在购买</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection