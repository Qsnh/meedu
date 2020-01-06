@extends('layouts.app')

@section('content')

    <div class="col-12 mt-140 mb-60">
        <div class="card card-shadowed px-50 py-30 w-400px mx-auto" style="max-width: 100%">
            <h5 class="text-uppercase text-center">找回密码</h5>
            <br>
            <form action="" class="form-horizontal" method="POST">
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
        </div>
        <p class="text-center text-muted fs-13 mt-20"><a class="text-primary fw-500" href="{{ route('login') }}">登录</a></p>
    </div>

@endsection