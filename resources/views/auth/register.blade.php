@extends('layouts.app')

@section('content')
    <div class="container auth-page">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="row">
                    <div class="col-sm-12 login-box">
                        <h3 class="text-center login-box-title">注册</h3>
                        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="nick_name">昵称</label>
                                <input id="nick_name" type="text" class="form-control" name="nick_name" value="{{ old('nick_name') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="mobile">手机号</label>
                                <input id="mobile" type="mobile" class="form-control" name="mobile" value="{{ old('mobile') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">密码</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">确认密码</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">登陆</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6">
                            </div>
                            <div class="col-sm-6 text-right">
                                <a class="btn btn-link" href="{{ route('login') }}">登陆</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection