@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 mt-20 mb-20 lg:max-w-6xl lg:mx-auto">
        <div class="flex justify-center">
            <div class="w-full lg:w-96">
                <form action="" method="post">
                    @csrf
                    <div class="bg-white rounded p-5 shadow">
                        <div class="text-2xl font-bold text-gray-800 mb-10 text-center mt-5">{{__('重置密码')}}</div>
                        <div class="mb-5">
                            @include('frontend.components.mobile', ['smsCaptchaKey' => 'password_reset'])
                            <div class="mb-5">
                                <input type="password" name="password"
                                       placeholder="{{__('请输入密码')}}"
                                       class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                       required>
                            </div>
                            <div class="mb-5">
                                <input type="password" name="password_confirmation"
                                       placeholder="{{__('再输入一次密码')}}"
                                       class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                       required>
                            </div>
                            <div class="flex">
                                <button type="submit"
                                        class="flex-1 rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                                    {{__('重置密码')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection