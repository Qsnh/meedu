@extends('frontend.layouts.app')

@section('content')

    <div class="w-full px-3 mt-20 mb-20 lg:max-w-6xl lg:mx-auto">
        <div class="flex justify-center">
            <div class="w-full lg:w-96">
                <div class="bg-white rounded p-5 shadow">
                    <div class="mb-5">
                        <div class="login-use-password">
                            <div class="text-2xl font-bold text-gray-800 mb-10 text-center mt-5">{{__('登录')}}</div>
                            <form action="{{route('login')}}" method="post">
                                @csrf
                                <div class="mb-5">
                                    <input type="text" name="mobile"
                                           placeholder="{{__('请输入手机号')}}"
                                           autocomplete="off"
                                           class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                           required>
                                </div>
                                <div class="mb-5">
                                    <input type="password" name="password"
                                           placeholder="{{__('请输入密码')}}"
                                           autocomplete="off"
                                           class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                           required>
                                </div>
                                <div class="mb-5 flex items-center">
                                    <div class="flex-1 flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="remember" type="checkbox"
                                                   name="remember" {{ old('remember') ? 'checked' : '' }}
                                                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-1 text-sm">
                                            <label for="remember" class="text-gray-500">{{__('15天内免登录')}}</label>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 text-right">
                                        <a class="text-gray-500 text-sm hover:text-blue-600"
                                           href="{{route('password.request')}}">{{__('忘记密码')}}</a>
                                    </div>
                                </div>
                                <div class="flex">
                                    <button type="submit"
                                            class="flex-1 rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                                        {{__('登录')}}
                                    </button>
                                </div>
                                <div class="my-3 flex items-center">
                                    <div class="flex-1">
                                        <a class="text-gray-500 text-sm hover:text-blue-600"
                                           onclick="$('.login-use-password').hide();$('.login-use-sms').show();"
                                           href="javascript:void(0)">{{__('手机短信登录')}}</a>
                                    </div>
                                    <div class="flex-1 text-right">
                                        <a class="text-sm text-gray-500 hover:text-blue-600"
                                           href="{{route('register')}}">{{__('没有账号？点此注册')}}</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="login-use-sms hidden">
                            <div class="text-2xl font-bold text-gray-800 mb-10 text-center mt-5">{{__('手机短信登录')}}</div>
                            @include('frontend.components.mobile', ['smsCaptchaKey' => 'mobile_login'])
                            <div class="flex">
                                <button type="button"
                                        data-url="{{route('ajax.login.mobile')}}"
                                        data-message-mobile-required="{{__('请输入手机号')}}"
                                        data-message-code-required="{{__('请输入短信验证码')}}"
                                        data-message-success="{{__('成功')}}"
                                        class="btn-login-sms flex-1 rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                                    {{__('登录')}}
                                </button>
                            </div>
                            <div class="my-3 flex items-center">
                                <div class="flex-1">
                                    <a class="text-gray-500 text-sm hover:text-blue-600"
                                       onclick="$('.login-use-sms').hide();$('.login-use-password').show();"
                                       href="javascript:void(0)">{{__('密码登录')}}</a>
                                </div>
                            </div>
                        </div>

                        @if(enabled_socialites()->isNotEmpty() || (int)$gConfig['mp_wechat']['enabled_scan_login'] === 1)
                            <div class="mt-10">
                                <div class="text-sm text-gray-500 text-center mb-5">
                                    {{__('第三方账号登录')}}
                                </div>
                                <div class="flex justify-center">
                                    @foreach(enabled_socialites() as $socialite)
                                        <a class="text-decoration-none mr-2"
                                           href="{{url_append_query(route('socialite', $socialite['app']), ['redirect' => request()->input('redirect', '')])}}">
                                            <img src="{{$socialite['logo']}}" class="object-cover" width="36"
                                                 height="36">
                                        </a>
                                    @endforeach

                                    @if((int)$gConfig['mp_wechat']['enabled_scan_login'] === 1)
                                        <a class="ml-2"
                                           href="{{url_append_query(route('login.wechat.scan'), ['redirect' => request()->input('redirect', '')])}}">
                                            <img class="object-cover" src="{{asset('/images/icons/wechat.svg')}}"
                                                 width="36" height="36">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection