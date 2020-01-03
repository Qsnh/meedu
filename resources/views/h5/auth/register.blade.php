@extends('h5.app')

@section('content')

    <form action="" method="post">
        @csrf
        <div class="weui-form">
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">注册</h2>
            </div>
            <div class="weui-form__control-area">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">昵称</label></div>
                            <div class="weui-cell__bd">
                                <input type="text" name="nick_name" value="{{old('nick_name')}}" class="weui-input"
                                       placeholder="填写昵称">
                            </div>
                        </div>
                        @include('h5.components.mobile', ['scene' => 'register'])
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                            <div class="weui-cell__bd">
                                <input type="password" name="password" class="weui-input" placeholder="填写密码">
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                            <div class="weui-cell__bd">
                                <input type="password" name="password_confirmation" class="weui-input"
                                       placeholder="再输入一次密码">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui-form__tips-area">
                <p class="weui-form__tips">
                    <a href="{{route('login')}}">登录</a>
                </p>
            </div>

            <div class="weui-form__opr-area">
                <button type="submit" class="weui-btn weui-btn_primary">注册</button>
            </div>
        </div>
    </form>



@endsection