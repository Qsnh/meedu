@extends('layouts.app')

@section('content')

    <div class="container auth-page">
        <div class="row justify-content-center">
            <div class="col-sm-4 login-box">
                <h3 class="text-center login-box-title">重置密码</h3>
                <form class="form-horizontal" method="POST">
                    @csrf
                    @include('components.frontend.mobile_captcha', ['smsCaptchaKey' => 'password_reset'])
                    <div class="form-group">
                        <label for="password">密码</label>
                        <input id="password" type="password" placeholder="请输入新密码" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">确认密码</label>
                        <input id="password-confirm" type="password" placeholder="再输入一次" class="form-control" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">重置密码</button>
                    </div>
                </form>

                <div class="text-right">
                    <a class="btn btn-link" href="{{ route('login') }}">登录</a>
                </div>
            </div>
        </div>
    </div>

@endsection