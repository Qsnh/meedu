@extends('layouts.h5')

@section('content')

    <div class="container-fluid bg-fff">
        <div class="row">
            <div class="col-12 pt-5 pb-3 px-3">
                <h3 class="mb-5">找回密码</h3>
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

            <div class="col-12 my-3 text-center">
                <a href="{{route('login')}}">点我登录</a>
            </div>

        </div>
    </div>

@endsection

@section('footer')

@endsection