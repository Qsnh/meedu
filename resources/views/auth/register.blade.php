@extends('layouts.app')

@section('content')
    <div class="col-12 mt-120 mb-60">
        <div class="card card-shadowed px-50 py-30 w-400px mx-auto" style="max-width: 100%">
            <h5 class="text-uppercase text-center">注册</h5>
            <br>
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
        </div>
        <p class="text-center text-muted fs-13 mt-20">已经有账号? <a class="text-primary fw-500" href="{{ route('login') }}">登录</a></p>
    </div>
@endsection