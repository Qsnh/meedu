@extends('layouts.app-active')

@section('css')
    <style>
        .member-nav-box {
            background-color: #323232;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid role-center-banner">
        <div class="row">
            <div class="col-12 text-center">
                <img src="/images/role-center.png" width="203" height="44">
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="role-list-box d-flex justify-content-center">
                        @foreach($gRoles as $index => $roleItem)
                            <div data-url="{{route('member.role.buy', [$roleItem['id']])}}"
                                 class="role-list-item {{$index % 3 === 0 ? 'first' : ''}}">
                                <div class="name">{{$roleItem['name']}}</div>
                                <div class="price">
                                    <small>￥</small>{{$roleItem['charge']}}</div>
                                <div class="desc">
                                    @foreach($roleItem['desc_rows'] as $item)
                                        <p>{{$item}}</p>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 text-center">
                    <a href="javascript:void(0)" class="role-join-button">开通会员</a>
                </div>
            </div>
        </div>
    </div>

@endsection