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

    <div class="container-fluid roles">
        <div class="row">
            <div class="col-sm-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-12 text-center">
                            <h3 class="title">计划</h3>
                        </div>

                        @foreach($roles as $role)
                            <div class="col-sm-4 roles-item">
                                <div class="roles-item-info text-center border">
                                    <h2 class="title">{{$role->name}}</h2>
                                    @foreach($role->descriptionRows() as $row)
                                        <p>{{$row}}</p>
                                    @endforeach
                                    <p class="price">￥{{$role->charge}}</p>
                                    <p>
                                        <a href="{{route('member.role.buy', $role)}}" class="buy-button">点我订阅</a>
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection