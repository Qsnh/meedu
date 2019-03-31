@extends('layouts.app')

@section('content')
    <div class="col-12 mt-120 mb-60">
        <div class="card card-shadowed px-50 py-30 w-400px mx-auto" style="max-width: 100%">
            <h5 class="text-uppercase text-center">登录</h5>
            <br>
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="mobile">手机号</label>
                    <input id="mobile" type="mobile" class="form-control" placeholder="手机号" name="mobile" value="{{ old('mobile') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">密码</label>
                    <input id="password" type="password" class="form-control" placeholder="密码" name="password" required>
                </div>

                <div class="form-group flexbox flex-column flex-md-row">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox"  class="custom-control-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">记住我</span>
                    </label>

                    <a class="text-muted hover-primary fs-13 mt-2 mt-md-0" href="{{ route('password.request') }}">忘记密码?</a>
                </div>

                <div class="form-group">
                    <button class="btn btn-bold btn-block btn-primary" type="submit">登录</button>
                </div>
            </form>

            @if(!enabled_socialites()->isEmpty())
            <div class="divider">使用下面账号登录</div>
            <div class="text-center">
                @foreach(enabled_socialites() as $socialite)
                    <a class="btn btn-square btn-dark" href="{{route('socialite', $socialite['app'])}}">{!! $socialite['icon'] !!}</a>
                @endforeach
            </div>
            @endif
        </div>
        <p class="text-center text-muted fs-13 mt-20">还没有账号? <a class="text-primary fw-500" href="{{ route('register') }}">注册</a></p>
    </div>
@endsection
