@extends('layouts.backend_base')

@section('base')
    <div class="row min-h-fullscreen center-vh p-20 m-0">
        <div class="col-12">
            <div class="card card-shadowed px-50 py-30 w-400px mx-auto" style="max-width: 100%">
                <h5 class="text-uppercase">后台登录</h5>
                <br>

                <form action="" method="post" class="form-type-material">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                        <label for="email">邮箱</label>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" id="password" name="password">
                        <label for="password">密码</label>
                    </div>

                    <div class="form-group flexbox flex-column flex-md-row">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember_me" value="1" class="custom-control-input" checked>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">记住我</span>
                        </label>

                        <a class="text-muted hover-primary fs-13 mt-2 mt-md-0" href="#">忘记密码?</a>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-bold btn-block btn-primary" type="submit">登录</button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="col-12 align-self-end text-center fs-13">
            <p class="mb-0"><small>Copyright © 2019 <a href="https://meedu.vip">MeEdu</a>. All rights reserved.</small></p>
        </footer>
    </div>

    @endsection