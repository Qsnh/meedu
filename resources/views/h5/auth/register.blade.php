@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '注册', 'back' => route('login')])

    <div class="box">
        <div class="login-title">
            注册
            <a href="{{route('login')}}" class="float-right">
                <small>登录</small>
            </a>
        </div>
        <form action="" method="post" onsubmit="return formSubmitCheck();">
            @csrf
            <div class="login-form">
                <div class="form-item">
                    <input type="text" name="nick_name" value="{{old('nick_name')}}" class="form-input-item"
                           placeholder="昵称" required>
                </div>
                @include('h5.components.mobile', ['smsCaptchaKey' => 'register'])
                <div class="form-item">
                    <input type="password" name="password" class="form-input-item" placeholder="密码" required>
                </div>
                <div class="form-item">
                    <input type="password" name="password_confirmation" class="form-input-item" placeholder="再输入一次密码"
                           required>
                </div>
                <div class="form-item protocol">
                    <label><input type="checkbox"
                                  name="agree_protocol" {{ old('remember') ? 'checked' : '' }}> 我已阅读并同意
                        <a href="{{route('user.protocol')}}" target="_blank">《{{config('app.name')}}
                            用户协议》</a></label>
                </div>
                <div class="form-item">
                    <button type="submit" class="login-button">注 册</button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('js')
    <script>
        function formSubmitCheck() {
            if ($('input[name="agree_protocol"]').is(':checked') === false) {
                flashWarning('请同意用户协议');
                return false;
            }
            return true;
        }
    </script>
@endsection