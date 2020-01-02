@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>订阅计划</strong>
            </h1>
        </div>
    </header>

    <div class="container pt-40 pb-40">
        <div class="row gap-y justify-content-center">
            @foreach($roles as $role)
                <div class="col-sm-12 col-md-3">
                    <div class="rounded text-center shadow-1 hover-shadow-3 transition-5s bg-white">
                        <p class="text-uppercase fs-13 fw-500 bb-1 py-3 ls-2">{{$role['name']}}</p>
                        <br>
                        <h2 class="fs-60 fw-500"><span class="price-dollar">￥</span> {{$role['charge']}}</h2>
                        <br>
                        @foreach(explode("\n", $role['description']) as $row)
                            <p>{{$row}}</p>
                        @endforeach
                        <br>
                        <a class="btn btn-success" href="{{route('member.role.buy', [$role['id']])}}">立即购买</a>
                        <br><br>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


@endsection