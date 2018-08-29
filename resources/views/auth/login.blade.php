@extends('layouts.app')

@section('content')
<div class="container auth-page">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="row">
                <div class="col-sm-12 login-box">
                    <h3 class="text-center login-box-title">登陆</h3>
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="mobile">手机号</label>
                            <input id="mobile" type="mobile" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">密码</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                            </label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">登陆</button>
                        </div>
                    </form>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <a class="btn btn-link" href="{{ route('register') }}">注册</a>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a class="btn btn-link" href="{{ route('password.request') }}">忘记密码</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
