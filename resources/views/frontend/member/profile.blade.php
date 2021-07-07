@extends('frontend.layouts.member')

@section('css')
    <link crossorigin="anonymous" integrity="sha384-Y5IVn/83T+2yb0XfIcu2KsXBq/nG2OAOizLhWBdeUXDs5B7XyrL+P3diZ0GvsS7J"
          href="https://lib.baomitu.com/flatpickr/3.1.5/flatpickr.min.css" rel="stylesheet">
@endsection

@section('member')

    @if($user['is_set_nickname'] === 0)
        <div class="mb-5">
            <div class="bg-white px-5 rounded shadow">
                <div class="text-gray-800 text-base font-medium pt-5 mb-5">{{__('昵称修改')}}</div>
                <div class="pb-5">
                    <div class="mb-5 flex items-center">
                        <div class="text-gray-500 text-sm">{{__('当前昵称')}}</div>
                        <div class="ml-3 text-gray-800 font-medium">
                            {{$user['nick_name']}}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-full flex items-center">
                            <input type="text" name="nickname"
                                   placeholder="{{__('请输入昵称')}}"
                                   autocomplete="off"
                                   class="flex-1 rounded border-gray-200 bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                   required>
                            <button type="button"
                                    data-message-required="{{__('请输入昵称')}}"
                                    data-message-success="{{__('成功')}}"
                                    data-url="{{route('ajax.nickname.change')}}"
                                    class="btn-nickname-change ml-5 rounded px-5 py-2 text-white bg-blue-600 hover:bg-blue-500">
                                {{__('修改')}}
                            </button>
                        </div>
                    </div>
                    <div class="text-gray-500 text-xs mt-2 pl-2">{{__('昵称只可修改一次')}}</div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white px-5 rounded shadow">
        <div class="text-gray-800 text-base font-medium pt-5 mb-5">{{__('头像修改')}}</div>
        <div class="pb-5">
            <div class="mb-5 flex items-center">
                <div class="text-gray-500 text-sm">{{__('当前头像')}}</div>
                <div class="ml-3">
                    <img src="{{$user['avatar']}}" width="40" height="40" class="rounded-full">
                </div>
            </div>
            <div class="flex items-center">
                <div class="hidden"><input type="file" name="avatar"></div>
                <div data-url="{{route('ajax.avatar.change')}}"
                     data-message-required="{{__('请选择头像')}}"
                     data-message-success="{{__('成功')}}"
                     class="btn-avatar-change flex-1 px-5 py-7 rounded cursor-pointer text-center text-gray-500 bg-gray-100 hover:text-gray-600 hover:bg-gray-100">
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 "
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div class="text-xs">
                        {{__('支持PNG,JPG,GIF格式图片，大小不超过2M')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5">
        <div class="bg-white px-5 rounded shadow">
            <div class="text-gray-800 text-base font-medium pt-5 mb-5">{{__('实名资料')}}</div>
            <div class="pb-5">
                <div class="flex items-center mb-5">
                    <div class="w-28">
                        <div class="text-gray-500 text-sm mb-2">{{__('真实姓名')}}</div>
                        <div>
                            <input type="text" name="real_name" value="{{$profile['real_name'] ?? ''}}"
                                   placeholder="{{__('真实姓名')}}"
                                   autocomplete="off"
                                   class="w-full border-gray-200 rounded bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                   required>
                        </div>
                    </div>
                    <div class="w-20 ml-5">
                        <div class="text-gray-500 text-sm mb-2">{{__('年龄')}}</div>
                        <div>
                            <input type="number" name="age" value="{{$profile['age'] ?? ''}}"
                                   placeholder="{{__('年龄')}}"
                                   autocomplete="off"
                                   class="w-full border-gray-200 rounded bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                   required>
                        </div>
                    </div>
                    <div class="w-24 ml-5">
                        <div class="text-gray-500 text-sm mb-2">{{__('性别')}}</div>
                        <div>
                            <select name="gender"
                                    class="block py-2 text-base border-gray-300 bg-gray-100 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                                <option value="0" {{(int)($profile['gender'] ?? 0) === 0 ? 'selected' : ''}}>{{__('不公开')}}</option>
                                <option value="1" {{(int)($profile['gender'] ?? 0) === 1 ? 'selected' : ''}}>{{__('男')}}</option>
                                <option value="2" {{(int)($profile['gender'] ?? 0) === 2 ? 'selected' : ''}}>{{__('女')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex-1 ml-5">
                        <div class="text-gray-500 text-sm mb-2">{{__('身份证号码')}}</div>
                        <div>
                            <input type="text" name="id_number" value="{{$profile['id_number'] ?? ''}}"
                                   placeholder="{{__('身份证号码')}}"
                                   autocomplete="off"
                                   class="w-full border-gray-200 rounded bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="flex items-center mb-5">
                    <div class="w-48">
                        <div class="text-gray-500 text-sm mb-2">{{__('生日')}}</div>
                        <div>
                            @if($profile['birthday'] ?? '')
                                <input type="text" name="birthday"
                                       value="{{\Carbon\Carbon::parse($profile['birthday'])->format('Y-m-d')}}"
                                       autocomplete="off"
                                       class="date w-full border-gray-200 rounded bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                       required>
                            @else
                                <input type="text" name="birthday"
                                       placeholder="{{__('请选择出生年月日')}}"
                                       autocomplete="off"
                                       class="date w-full border-gray-200 rounded bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                       required>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 ml-5">
                        <div class="text-gray-500 text-sm mb-2">{{__('职业')}}</div>
                        <div>
                            <input type="text" name="profession" value="{{$profile['profession'] ?? ''}}"
                                   placeholder="{{__('职业')}}"
                                   autocomplete="off"
                                   class="w-full border-gray-200 rounded bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                                   required>
                        </div>
                    </div>
                </div>


                <div class="w-full mb-5">
                    <div class="text-gray-500 text-sm mb-2">{{__('住址')}}</div>
                    <div>
                        @include('frontend.components.china-province-select', ['provinceSelected' => explode('-', $profile['address'] ?? '')])
                    </div>
                </div>

                <div class="w-full mb-5">
                    <div class="text-gray-500 text-sm mb-2">{{__('毕业院校')}}</div>
                    <div>
                        <input type="text" name="graduated_school" value="{{$profile['graduated_school'] ?? ''}}"
                               placeholder="{{__('毕业院校')}}"
                               autocomplete="off"
                               class="w-full border-gray-200 rounded bg-gray-100 px-3 py-2 focus:ring-1 focus:ring-blue-600 focus:bg-white"
                               required>
                    </div>
                </div>

                <div class="w-full mb-5">
                    <div class="text-gray-500 text-sm mb-2">{{__('毕业证照片')}}</div>
                    <div>
                        <div class="mb-3 diploma-preview">
                            @if($profile['diploma'] ?? '')
                                <img src="{{$profile['diploma']}}" width="200"
                                     class="object-cover rounded mb-3">
                            @endif
                        </div>
                        <div class="hidden">
                            <input type="text" name="diploma" value="{{$profile['diploma'] ?? ''}}">
                            <input type="file" name="file_diploma">
                        </div>
                        <div data-url="{{route('upload.image')}}"
                             data-input-name="diploma"
                             data-file-input-name="file_diploma"
                             data-message-required="{{__('请选择图片')}}"
                             data-message-success="{{__('成功')}}"
                             class="btn-image-upload px-5 py-7 rounded cursor-pointer text-center text-gray-500 bg-gray-100 hover:text-gray-600 hover:bg-gray-100">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 "
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="text-xs">
                                {{__('支持PNG,JPG,GIF格式图片，大小不超过2M')}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full mb-5">
                    <div class="text-gray-500 text-sm mb-2">{{__('身份证正面照')}}</div>
                    <div>
                        <div class="mb-3 id_frontend_thumb-preview">
                            @if($profile['id_frontend_thumb'] ?? '')
                                <img src="{{$profile['id_frontend_thumb']}}" width="200"
                                     class="object-cover rounded mb-3">
                            @endif
                        </div>
                        <div class="hidden">
                            <input type="text" name="id_frontend_thumb" value="{{$profile['id_frontend_thumb'] ?? ''}}">
                            <input type="file" name="file_id_frontend_thumb">
                        </div>
                        <div data-url="{{route('upload.image')}}"
                             data-input-name="id_frontend_thumb"
                             data-file-input-name="file_id_frontend_thumb"
                             data-message-required="{{__('请选择图片')}}"
                             data-message-success="{{__('成功')}}"
                             class="btn-image-upload px-5 py-7 rounded cursor-pointer text-center text-gray-500 bg-gray-100 hover:text-gray-600 hover:bg-gray-100">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 "
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="text-xs">
                                {{__('支持PNG,JPG,GIF格式图片，大小不超过2M')}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full mb-5">
                    <div class="text-gray-500 text-sm mb-2">{{__('身份证反面照')}}</div>
                    <div>
                        <div class="mb-3 id_backend_thumb-preview">
                            @if($profile['id_backend_thumb'] ?? '')
                                <img src="{{$profile['id_backend_thumb']}}" width="200"
                                     class="object-cover rounded mb-3">
                            @endif
                        </div>
                        <div class="hidden">
                            <input type="text" name="id_backend_thumb" value="{{$profile['id_backend_thumb'] ?? ''}}">
                            <input type="file" name="file_id_backend_thumb">
                        </div>
                        <div data-url="{{route('upload.image')}}"
                             data-input-name="id_backend_thumb"
                             data-file-input-name="file_id_backend_thumb"
                             data-message-required="{{__('请选择图片')}}"
                             data-message-success="{{__('成功')}}"
                             class="btn-image-upload px-5 py-7 rounded cursor-pointer text-center text-gray-500 bg-gray-100 hover:text-gray-600 hover:bg-gray-100">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 "
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="text-xs">
                                {{__('支持PNG,JPG,GIF格式图片，大小不超过2M')}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full mb-5">
                    <div class="text-gray-500 text-sm mb-2">{{__('手持身份证照片')}}</div>
                    <div>
                        <div class="mb-3 id_hand_thumb-preview">
                            @if($profile['id_hand_thumb'] ?? '')
                                <img src="{{$profile['id_hand_thumb']}}" width="200" class="object-cover rounded mb-3">
                            @endif
                        </div>
                        <div class="hidden">
                            <input type="text" name="id_hand_thumb" value="{{$profile['id_hand_thumb'] ?? ''}}">
                            <input type="file" name="file_id_hand_thumb">
                        </div>
                        <div data-url="{{route('upload.image')}}"
                             data-input-name="id_hand_thumb"
                             data-file-input-name="file_id_hand_thumb"
                             data-message-required="{{__('请选择图片')}}"
                             data-message-success="{{__('成功')}}"
                             class="btn-image-upload px-5 py-7 rounded cursor-pointer text-center text-gray-500 bg-gray-100 hover:text-gray-600 hover:bg-gray-100">
                            <div class="mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-7 w-7 "
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <div class="text-xs">
                                {{__('支持PNG,JPG,GIF格式图片，大小不超过2M')}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full text-right">
                    <button type="submit"
                            data-url="{{route('ajax.member.profile.update')}}"
                            data-message-success="{{__('成功')}}"
                            class="btn-profile-change ml-5 rounded px-5 py-2 text-white bg-blue-600 hover:bg-blue-500">
                        {{__('保存')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if(app()->make(\App\Businesses\BusinessState::class)->isNeedBindMobile($user))
        <div class="mt-5">
            <div class="bg-white px-5 rounded shadow">
                <div class="text-gray-800 text-base font-medium pt-5 mb-5">{{__('绑定手机号')}}</div>
                <div class="pb-5">
                    <div class="w-96">
                        @include('frontend.components.mobile', ['smsCaptchaKey' => 'mobile_bind'])
                        <div>
                            <button type="submit"
                                    data-url="{{route('ajax.mobile.bind')}}"
                                    ata-message-success="{{__('成功')}}"
                                    data-message-required="{{__('请输入手机号')}}"
                                    data-message-code-required="{{__('请输入短信验证码')}}"
                                    class="btn-mobile-bind w-full rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                                {{__('绑定手机号')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="mt-5">
            <div class="bg-white px-5 rounded shadow">
                <div class="text-gray-800 text-base font-medium pt-5 mb-5">{{__('更换手机号')}}</div>
                <div class="pb-5">
                    <div class="w-96">
                        <div class="text-gray-600 mb-5">
                            {{__('当前手机号 :mobile', ['mobile' => $user['mobile']])}}
                        </div>
                        @include('frontend.components.mobile', ['smsCaptchaKey' => 'mobile_bind'])
                        <div>
                            <button type="submit"
                                    data-url="{{route('ajax.mobile.change')}}"
                                    ata-message-success="{{__('成功')}}"
                                    data-message-required="{{__('请输入手机号')}}"
                                    data-message-code-required="{{__('请输入短信验证码')}}"
                                    class="btn-mobile-bind w-full rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
                                {{__('更换手机号')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('js')
    <script src="{{asset('/js/china-province-map.js')}}"></script>
    <script crossorigin="anonymous" integrity="sha384-AyxBgmPbhAVDWlJkouN5YxPYcOzhCa3NzYMnHf50YfTOVVmcERVzd51znc16zfHW"
            src="https://lib.baomitu.com/flatpickr/3.1.5/flatpickr.min.js"></script>
    <script src="{{asset('/js/flatpickr/zh.js')}}"></script>
    <script>
        $(function () {
            flatpickr('.date', {
                locale: '{{config('app.locale')}}',
                @if($profile['birthday'] ?? '')
                defaultDate: '{{\Carbon\Carbon::parse($profile['birthday'])->format('Y-m-d')}}',
                @endif
            });
        });
    </script>
@endsection