@extends('layouts.app')

@section('content')

    <header class="header bg-ui-general header-inverse">
        <div class="header-info">
            <h1 class="header-title">
                <strong>购买视频</strong>
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
                                <img src="{{$gConfig['system']['logo']}}" alt="logo">
                            </div>
                            <div class="col-md-6 text-center text-md-right">
                            </div>
                        </div>
                    </header>
                    <div>
                        <div class="media-list media-list-divided bb-1 border-light">
                            <div class="media align-items-center p-40">
                                <div class="media-body">
                                    <h4>{{$video['title']}}</h4>
                                </div>
                                <h4 class="text-primary fw-500">￥{{$video['charge']}}</h4>
                            </div>
                        </div>
                        <br><br>
                        <div class="p-40 text-right">
                            <div>
                                <small class="text-uppercase text-muted">总价</small>
                                <span class="w-150px d-inline-block fw-400">￥{{$video['charge']}}</span>
                            </div>
                            <div>
                                <small class="text-uppercase text-muted">折扣</small>
                                <span class="w-150px d-inline-block fw-400 discount">-￥0</span>
                            </div>

                            <hr class="hr-sm w-50 mr-0">

                            <h4 class="text-uppercase">
                                <strong class="fs-14">总计</strong>
                                <div class="w-150px d-inline-block text-primary">
                                    <span class="fw-500 fs-20 total">￥{{$video['charge']}}</span>
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
                        <input type="hidden" name="promo_code_id" value="0">
                        <button type="submit" class="btn btn-block btn-bold btn-lg btn-primary no-radius">现在购买</button>
                    </form>
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
                    } else {
                        $('.discount').text('-￥0');
                        $('.total').text('￥' + totalCharge);
                        $('input[name="promo_code_id"]').val(0);
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
                }
            });
        });
    </script>
@endsection