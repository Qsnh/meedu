@extends('layouts.member')

@section('member')

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form class="card" method="post" action="">
                    @csrf
                    <h4 class="card-title"><strong>绑定手机号</strong></h4>

                    <div class="card-body">
                        @include('components.frontend.mobile_captcha', ['smsCaptchaKey' => 'mobile_bind'])
                    </div>

                    <footer class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">确认绑定此手机号</button>
                    </footer>
                </form>
            </div>
        </div>
    </div>

@endsection