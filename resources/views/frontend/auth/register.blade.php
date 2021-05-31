@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 mt-20 mb-20 lg:max-w-6xl lg:mx-auto">
        <div class="flex justify-center">
            <div class="w-full lg:w-96">
                <form action="{{route('register')}}" method="post" class="register-form">
                    @csrf
                    <div class="bg-white rounded p-5 shadow">
                        <div class="text-2xl font-bold text-gray-800 mb-10 text-center mt-5">{{__('注册')}}</div>
                        <div class="mb-5">
                            @include('frontend.components.mobile', ['smsCaptchaKey' => 'register'])
                            <div class="mb-5">
                                <input type="password" name="password"
                                       placeholder="{{__('请输入密码')}}"
                                       class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                       required>
                            </div>
                            <div class="mb-5">
                                <div class="flex items-center h-5">
                                    <input id="agree-protocol" type="checkbox" name="agree_protocol"
                                           class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    <div class="ml-1 text-sm text-gray-500">
                                        <a href="{{route('user.protocol')}}" target="_blank"
                                           class="text-blue-600">{{__('《用户协议》')}}</a>
                                        和
                                        <a href="{{route('user.private_protocol')}}" class="text-blue-600"
                                           target="_blank">{{__('《用户隐私协议》')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="flex">
                                <button type="submit"
                                        class="flex-1 rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                                    {{__('注册')}}
                                </button>
                            </div>
                            <div class="my-3 text-center">
                                <a class="text-sm text-gray-500 hover:text-gray-600"
                                   href="{{route('login')}}">{{__('已有账号？点此登录')}}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection