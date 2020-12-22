@extends('layouts.app')

@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-4 br-8 mb-4">
                <div class="card">
                    <div class="card-header">绑定手机号</div>
                    <div class="card-body">
                        <form method="post" action="">
                            @csrf
                            @include('frontend.components.mobile', ['smsCaptchaKey' => 'mobile_bind'])
                            <div class="form-group auth-box-errors" style="color: red;"></div>
                            <div class="form-group text-right mt-3">
                                <button class="btn btn-primary btn-block" type="submit">确定绑定该手机号</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection