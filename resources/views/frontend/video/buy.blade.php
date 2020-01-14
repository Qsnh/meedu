@extends('layouts.app')

@section('css')
    <style>
        body {
            background-color: #f6f6f6;
        }
    </style>
@endsection

@section('content')

    <div class="container my-5">
        <div class="row">
            <div class="col-12 py-4 br-8">
                <div class="w-100 float-left bg-fff br-8 box-shadow1">
                    <div class="row">
                        <div class="col-12 px-5 py-4">
                            <h2 class="fw-400 c-primary pb-4 border-bottom border-secondary">收银台</h2>
                            <div class="row py-5 border-bottom border-secondary">
                                <div class="col-md-8 col-12">
                                    <h4 class="fw-400">{{$video['title']}}</h4>
                                </div>
                                <div class="col-md-4 col-12 text-right">
                                    <span class="fs-24px">￥{{$video['charge']}}</span>
                                </div>
                            </div>
                            <div class="row py-5">
                                <div class="col-12 text-right">
                                    <p>总价<span class="ml-3">￥{{$video['charge']}}</span></p>
                                    <p class="mb-0">折扣<span class="discount ml-3">￥0</span></p>
                                </div>
                            </div>
                            <div class="row py-5 border-secondary border-bottom justify-content-end">
                                <div class="col-md-3 col-12">
                                    <div class="input-group mb-3">
                                        <input type="text" name="promo_code" class="form-control" placeholder="优惠码"
                                               value="{{\Illuminate\Support\Facades\Cookie::get('promo_code')}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-sm promoCodeCheckButton" type="button">
                                                检测
                                            </button>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted promo_code_status"></small>
                                </div>
                            </div>
                            <div class="row py-5 justify-content-end">
                                <div class="col-md-3 col-12 text-right">
                                    <p class="text-right">总计 <span class="ml-4 total">￥{{$video['charge']}}</span></p>
                                    <form action="" method="post">
                                        @csrf
                                        <input type="hidden" name="promo_code_id" value="">
                                        <button type="submit"
                                                class="btn btn-primary mt-4">提交订单
                                        </button>
                                    </form>
                                </div>
                            </div>
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

@section('js')
    <script>
        var totalCharge = {{$video['charge']}};
        $(function () {
            var promoCode = $('input[name="promo_code"]').val();
            var promoCodeCheck = function (code) {
                $.post('{{route('ajax.promo_code.check')}}', {
                    promo_code: code,
                    _token: '{{csrf_token()}}'
                }, function (res) {
                    if (res.code === 0) {
                        $('.discount').text('-￥' + res.data.discount);
                        var newTotal = totalCharge - res.data.discount;
                        if (newTotal < 0) {
                            newTotal = 0;
                        }
                        $('.total').text('￥' + newTotal);
                        $('input[name="promo_code_id"]').val(res.data.id);
                        $('.promo_code_status').text('有效');
                    } else {
                        $('.discount').text('-￥0');
                        $('.total').text('￥' + totalCharge);
                        $('input[name="promo_code_id"]').val(0);
                        $('.promo_code_status').text(res.message);
                    }
                }, 'json');
            };
            if (promoCode) {
                promoCodeCheck(promoCode);
            }

            $('.promoCodeCheckButton').click(function () {
                var promoCode = $('input[name="promo_code"]').val();
                if (promoCode) {
                    promoCodeCheck(promoCode);
                } else {
                    $('.discount').text('-￥0');
                    $('.total').text('￥' + totalCharge);
                    $('input[name="promo_code_id"]').val(0);
                    $('.promo_code_status').text('');
                }
            });
        });
    </script>
@endsection