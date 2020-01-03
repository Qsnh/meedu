@extends('h5.app')

@section('content')

    <form action="" method="post">
        @csrf
        <div class="weui-form">
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">登录</h2>
            </div>
            <div class="weui-form__control-area">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
                            <div class="weui-cell__bd">
                                <input type="text" name="mobile" value="{{old('mobile')}}" class="weui-input" placeholder="填写手机号">
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                            <div class="weui-cell__bd">
                                <input type="password" name="password" class="weui-input" placeholder="填写密码">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-form__tips-area">
                <p class="weui-form__tips">
                    <a href="{{route('password.request')}}">忘记密码？</a> | <a href="{{route('register')}}">注册</a>
                </p>
            </div>

            <div class="weui-form__opr-area">
                <button type="submit" class="weui-btn weui-btn_primary">登录</button>
            </div>
        </div>
    </form>

@endsection