@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 recharge-banner">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3>账户充值</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-4 recharge-form-box">
                <div class="alert alert-warning">
                    <p><b>注意：</b></p>
                    <p>1.充值之后无法提现只能在本站消费使用。</p>
                </div>
                <form action="" method="post" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label>金额</label>
                        <div class="input-group">
                            <input type="text" name="money" placeholder="金额" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text">元</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">立即充值</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection