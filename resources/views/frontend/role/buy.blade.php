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
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <h3 class="text-center">你正在购买VIP <b>{{$role->name}}</b></h3>
                <ul class="list-group">
                    @foreach($role->descriptionRows() as $row)
                        <li class="list-group-item">{{$row}}</li>
                    @endforeach
                </ul>

                <p class="lh-30">价格：<b>￥{{$role->charge}}</b></p>
                <p class="lh-30">当前账户余额：<b>￥{{$user->credit1}}</b></p>

                @if($user->credit1 < $role->charge)
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