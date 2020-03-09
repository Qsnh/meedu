@extends('layouts.h5')

@section('content')

    @include('h5.components.topbar', ['back' => route('member'), 'backText' => '会员中心', 'title' => '收银台'])

    <div class="container-fluid bg-fff my-5">
        <div class="row">
            <div class="col-12 py-3 text-center">
                <span style="color: green">支付成功</span>
            </div>
        </div>
    </div>

@endsection