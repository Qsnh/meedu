@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '找回密码', 'back' => route('login')])

    <div class="box">
        <div class="login-title">
            找回密码
            <a href="{{route('login')}}" class="float-right">
                <small>登录</small>
            </a>
        </div>
        <form action="" method="post">
            @csrf
            <div class="login-form">
                @include('h5.components.mobile', ['smsCaptchaKey' => 'register'])
                <div class="form-item">
                    <input type="password" name="password" class="form-input-item" placeholder="密码" required>
                </div>
                <div class="form-item">
                    <input type="password" name="password_confirmation" class="form-input-item" placeholder="再输入一次密码"
                           required>
                </div>
                <div class="form-item">
                    <button type="submit" class="login-button">重置密码</button>
                </div>
            </div>
        </form>
    </div>

@endsection