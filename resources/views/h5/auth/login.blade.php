@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '登录'])

    <div class="box">
        <div class="login-title">
            密码登录
            <small onclick="$('.box').html($('#mobile-login').html())" class="float-right">手机号登录</small>
        </div>
        <form action="" method="post">
            @csrf
            <div class="login-form">
                <div class="form-item">
                    <input type="text" name="mobile" value="{{old('mobile')}}" class="form-input-item" placeholder="手机号"
                           required>
                </div>
                <div class="form-item">
                    <input type="password" name="password" class="form-input-item" placeholder="密码" required>
                </div>
                <div class="form-item login-link">
                    <a href="{{route('register')}}" class="mr-1">注册</a> | <a class="ml-1"
                                                                             href="{{route('password.request')}}">忘记密码？</a>
                </div>

                <div class="form-item">
                    <button type="submit" class="login-button">登 录</button>
                </div>
            </div>
        </form>
    </div>

    <div class="socialite-login text-center">
        @if(!enabled_socialites()->isEmpty())
            @foreach(enabled_socialites() as $socialite)
                <a class="mr-3"
                   href="{{route('socialite', $socialite['app'])}}">
                    <img src="{{$socialite['logo']}}" width="48" height="48">
                </a>
            @endforeach
        @endif
    </div>

    <script type="text/html" id="mobile-login">
        <div class="login-title">
            手机号登录
            <small onclick="$('.box').html($('#password-login').html())"
                   class="float-right">密码登录
            </small>
        </div>
        <form action="" class="mobile-login-form">
            @csrf
            <div class="login-form">
                @include('h5.components.mobile', ['smsCaptchaKey' => 'mobile_login'])
                <div class="form-item login-link">
                    <a href="{{route('register')}}" class="mr-1">注册</a> | <a class="ml-1"
                                                                             href="{{route('password.request')}}">忘记密码？</a>
                </div>
                <div class="form-item">
                    <button type="button" data-url="{{route('ajax.login.mobile')}}" class="btn btn-primary btn-block login-button mobile-login-button">登录</button>
                </div>
            </div>
        </form>
    </script>

    <script type="text/html" id="password-login">
        <div class="login-title">
            密码登录
            <small onclick="$('.box').html($('#mobile-login').html())"
                   class="float-right">手机号登录
            </small>
        </div>
        <form action="" method="post">
            @csrf
            <div class="login-form">
                <div class="form-item">
                    <input type="text" name="mobile" class="form-input-item" placeholder="手机号">
                </div>
                <div class="form-item">
                    <input type="password" name="password" class="form-input-item" placeholder="密码">
                </div>
                <div class="form-item login-link">
                    <a href="{{route('register')}}" class="mr-1">注册</a> | <a class="ml-1"
                                                                             href="{{route('password.request')}}">忘记密码？</a>
                </div>

                <div class="form-item">
                    <button type="submit" class="login-button">登录</button>
                </div>
            </div>
        </form>
    </script>

@endsection