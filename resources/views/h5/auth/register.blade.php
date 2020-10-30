@extends('layouts.h5-pure')

@section('content')

    @include('h5.components.topbar', ['title' => '注册'])

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
                @include('h5.components.mobile', ['smsCaptchaKey' => 'register'])
                <div class="form-item">
                    <input type="password" name="password" class="form-input-item" placeholder="密码" required>
                </div>
                <div class="form-item protocol">
                    <label><input type="checkbox"
                                  name="agree_protocol" {{ old('remember') ? 'checked' : '' }}> 同意
                        <a href="{{route('user.protocol')}}" target="_blank">《 用户协议》</a> 和 <a
                                href="{{route('user.private_protocol')}}" target="_blank">《隐私政策》</a></label>
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
                flashWarning('请同意协议');
                return false;
            }
            return true;
        }
    </script>
@endsection