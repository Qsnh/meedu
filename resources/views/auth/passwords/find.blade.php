@extends('layouts.app')

@section('content')

    <div class="container auth-page">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="row">
                    <div class="col-sm-12 login-box">
                        <h3 class="text-center login-box-title">重置密码</h3>
                        <form class="form-horizontal" method="POST">
                            {{ csrf_field() }}
                            @include('components.frontend.mobile_captcha')
                            <div class="form-group">
                                <label for="password">密码</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">确认密码</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">重置密码</button>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-6"></div>
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