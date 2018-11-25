@extends('layouts.app')

@section('content')
<div class="container auth-page">
    <div class="row justify-content-center">
        <div class="col-sm-4 login-box">
            <h3 class="text-center login-box-title">登录</h3>
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="mobile">手机号</label>
                    <input id="mobile" type="mobile" class="form-control" placeholder="手机号" name="mobile" value="{{ old('mobile') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <input id="password" type="password" class="form-control" placeholder="密码" name="password" required>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">登录</button>
                </div>
            </form>

            <div>
                <a class="btn btn-link" href="{{ route('register') }}">注册</a>
                <a class="btn btn-link float-right" href="{{ route('password.request') }}">忘记密码</a>
            </div>
        </div>
    </div>
</div>
@endsection
