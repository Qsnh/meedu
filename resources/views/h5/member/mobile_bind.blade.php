@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '绑定手机号'])

    <div class="box">
        <div class="login-title">
            绑定手机号
        </div>
        <form action="" method="post">
            @csrf
            <div class="login-form">
                @include('h5.components.mobile', ['smsCaptchaKey' => 'mobile_bind'])
                <div class="form-item">
                    <button type="submit" class="login-button">确认绑定</button>
                </div>
            </div>
        </form>
    </div>

@endsection