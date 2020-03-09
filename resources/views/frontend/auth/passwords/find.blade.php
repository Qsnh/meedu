@extends('layouts.app')

@section('content')

    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 bg-fff pt-5 pb-3 px-5 br-8 box-shadow1 fs-14px">
                            <h3 class="mb-5">找回密码
                                <small class="fs-14px"><a href="{{route('login')}}">点此登录</a></small>
                            </h3>
                            <form action="" method="post">
                                @csrf
                                @include('frontend.components.mobile', ['smsCaptchaKey' => 'password_reset'])
                                <div class="form-group">
                                    <label for="password">密码</label>
                                    <input id="password" type="password" placeholder="请输入新密码" class="form-control"
                                           name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password-confirm">确认密码</label>
                                    <input id="password-confirm" type="password" placeholder="再输入一次"
                                           class="form-control" name="password_confirmation" required>
                                </div>
                                <div class="form-group mt-2">
                                    <button class="btn btn-primary btn-block">重置密码</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection