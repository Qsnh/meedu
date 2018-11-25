@extends('layouts.app')

@section('content')
    <div class="container auth-page">
        <div class="row justify-content-center">
            <div class="col-sm-4 login-box">
                <h3 class="text-center login-box-title">注册</h3>
                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nick_name">昵称</label>
                        <input id="nick_name" type="text" class="form-control" placeholder="昵称" name="nick_name" value="{{ old('nick_name') }}" required>
                    </div>
                    @include('components.frontend.mobile_captcha', ['smsCaptchaKey' => 'register'])
                    <div class="form-group">
                        <label for="password">密码</label>
                        <input id="password" type="password" class="form-control" placeholder="密码" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">确认密码</label>
                        <input id="password-confirm" type="password" class="form-control" placeholder="再输入一次" name="password_confirmation" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">注册</button>
                    </div>
                </form>

                <div class="text-right">
                    <a class="btn btn-link" href="{{ route('login') }}">登录</a>
                </div>
            </div>
        </div>
    </div>
@endsection