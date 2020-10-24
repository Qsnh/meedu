@extends('layouts.h5-pure')

@section('css')
    <style>
        body {
            padding-bottom: 49px;
        }
    </style>
@endsection

@section('content')

    @include('h5.components.topbar', ['title' => '会员中心', 'back' => route('index'), 'class' => 'dark'])

    <div class="box">
        <div class="role-page-title">
            开通会员
        </div>
        <div class="role-item-box">
            @foreach($gRoles as $index => $roleItem)
                <div class="role-item" data-url="{{route('member.role.buy', [$roleItem['id']])}}">
                    <div class="name">{{$roleItem['name']}}</div>
                    <div class="price">
                        <small>￥</small>{{$roleItem['charge']}}
                    </div>
                    <div class="desc">
                        @foreach($roleItem['desc_rows'] as $item)
                            <p>{{$item}}</p>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <a href="javascript:void(0)" class="role-subscribe-button focus-c-white">
        立即支付
    </a>

@endsection