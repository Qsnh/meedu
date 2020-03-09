@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12 bg-fff br-8 px-5 py-4">
                <div class="w-100 float-left">
                    <div class="row">
                        <div class="col-12">
                            <h2>支付成功</h2>
                        </div>
                        <div class="col-12">
                            <p class="mt-4 text-right">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                        </div>
                        <div class="col-12 py-3 text-center text-success">
                            <i class="fa fa-check-circle-o fa-5x" aria-hidden="true"></i>
                        </div>
                        <div class="col-12 text-right">
                            <a href="{{route('member.orders')}}" class="btn btn-primary">我的订单</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.components.recom_courses')

@endsection