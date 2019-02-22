@extends('layouts.member')

@section('member')

    <div class="row">
        <h3>绑定手机号</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-sm-4" style="margin-top: 50px;">
            <form action="" method="post" class="form-horizontal">
                @csrf
                @include('components.frontend.mobile_captcha', ['smsCaptchaKey' => 'mobile_bind'])
                <div class="form-group">
                    <button class="btn btn-primary btn-block">确认绑定此手机号</button>
                </div>
            </form>
        </div>
    </div>

@endsection