@extends('layouts.app')

@section('content')

    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-4 bg-fff pt-5 pb-3 px-5 br-8 box-shadow1 fs-14px">
                            <h3 class="mb-5">账号注册
                                <small class="fs-14px"><a href="{{route('login')}}">已有账号？点此登录</a></small>
                            </h3>
                            <form action="" method="post" onsubmit="return formSubmitCheck();">
                                @csrf
                                @include('frontend.components.mobile', ['smsCaptchaKey' => 'register'])
                                <div class="form-group">
                                    <label for="password">密码</label>
                                    <input id="password" type="password" class="form-control" placeholder="密码"
                                           name="password" required>
                                </div>
                                <div class="form-group auth-box-errors" style="color: red;"></div>
                                <div class="form-group">
                                    <label><input type="checkbox"
                                                  name="agree_protocol" {{ old('remember') ? 'checked' : '' }}> 同意
                                        <a href="{{route('user.protocol')}}" target="_blank">《用户协议》</a> 和 <a
                                                href="{{route('user.private_protocol')}}"
                                                target="_blank">《隐私政策》</a></label>
                                </div>
                                <div class="form-group mt-2">
                                    <button class="btn btn-primary btn-block">注册</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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