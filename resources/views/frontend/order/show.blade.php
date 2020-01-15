@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-12 bg-fff br-8 px-5 py-4">
                <div class="w-100 float-left">
                    <div class="row">
                        <div class="col-12">
                            <h2>支付方式</h2>
                        </div>
                        <div class="col-12">
                            <p class="mt-4 text-right">订单号 <span class="ml-3">{{$order['order_id']}}</span></p>
                            <p class="text-right">支付总额 <span class="ml-3">￥{{$needPaidTotal}}</span></p>
                        </div>
                        <div class="col-12 text-right">
                            <form action="{{route('order.pay', [$order['order_id']])}}" method="post">
                                @csrf
                                <div class="form-group">
                                    @foreach($payments as $index => $payment)
                                        <label class="mr-3"><input type="radio" name="payment"
                                                                   value="{{$payment['sign']}}" {{$index == 0 ? 'checked' : ''}}>
                                            <span class="ml-3">{{$payment['name']}}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mt-3">提交订单</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-12 mt-5">
                <h3 class="c-2 mt-3">常见问题</h3>
                <div class="accordion mt-4" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left c-2" type="button"
                                        data-toggle="collapse" data-target="#collapseOne"
                                        aria-expanded="true" aria-controls="collapseOne">
                                    购买之后如果不满意是否可以退款？
                                </button>
                            </h2>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                本站所有收费资源，包括但不限制课程，视频，套餐等一经购买均不可以退款，如果问题请联系客服。
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection