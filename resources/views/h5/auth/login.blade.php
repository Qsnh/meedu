@extends('layouts.h5')

@section('content')

    <div class="container-fluid bg-fff">
        <div class="row">
            <div class="col-12 pt-5 pb-3 px-3">
                <h3 class="mb-5">账号登录</h3>
                <form action="" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="mobile">手机号</label>
                        <input id="mobile" type="mobile" class="form-control" placeholder="手机号"
                               name="mobile" value="{{ old('mobile') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">密码</label>
                        <input id="password" type="password" class="form-control" placeholder="密码"
                               name="password" required>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox"
                                      name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我</label>
                        <a href="{{ route('password.request') }}" class="float-right">忘记密码？</a>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-primary btn-block">登录</button>
                    </div>
                    @if(!enabled_socialites()->isEmpty())
                        <div class="form-group text-center c-2">
                            <p>其它方式登录</p>
                        </div>
                        <div class="form-group text-center">
                            @foreach(enabled_socialites() as $socialite)
                                <a class="mr-2"
                                   href="{{route('socialite', $socialite['app'])}}">
                                    <img src="{{$socialite['logo']}}" width="24" height="24">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </form>
            </div>

            <div class="col-12 my-3 text-center">
                <a href="{{route('register')}}">点我注册</a>
            </div>

        </div>
    </div>

@endsection