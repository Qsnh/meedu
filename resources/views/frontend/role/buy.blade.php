@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>购买VIP</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container all-buy-box">
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <h3 style="line-height: 100px;" class="text-center">你正在购买VIP <b>{{$role->name}}</b></h3>
                <h5>权益如下</h5>
                <ul class="list-group">
                    @foreach($role->descriptionRows() as $row)
                        <li class="list-group-item">{{$row}}</li>
                    @endforeach
                </ul>

                <div style="margin-top: 15px;">
                    <h1 class="text-center">￥{{$role->charge}}</h1>
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