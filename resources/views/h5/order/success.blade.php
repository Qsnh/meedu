@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '支付成功', 'back' => route('index'), 'class' => 'dark'])

    <div class="box">
        <div class="page-title">
            支付成功
        </div>
        <div>
            <p class="mt-4">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
        </div>
    </div>

@endsection