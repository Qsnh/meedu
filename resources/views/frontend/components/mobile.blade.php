<div class="mb-5">
    <input type="text" name="mobile"
           placeholder="{{__('请输入手机号')}}"
           autocomplete="off"
           class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white" required>
</div>
<div class="mb-5 flex items-center">
    <div class="flex-1">
        <input type="text" name="captcha"
               placeholder="{{__('图形验证码')}}"
               autocomplete="off"
               class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white"
               required>
    </div>
    <div class="flex-shrink-0 ml-3">
        <img src="{{ captcha_src() }}" class="captcha object-cover rounded" height="48">
    </div>
</div>
<div class="mb-5 flex items-center">
    <div class="flex-1">
        <input type="hidden" name="sms_captcha_key" value="{{$smsCaptchaKey ?? ''}}">
        <input type="text" name="sms_captcha"
               placeholder="{{__('短信验证码')}}"
               autocomplete="off"
               class="w-full rounded border-gray-200 bg-gray-200 px-3 py-3 focus:ring-1 focus:ring-blue-600 focus:bg-white"
               required>
    </div>
    <div class="flex-shrink-0 ml-3">
        <button type="button"
                style="width: 120px"
                data-btn-text="{{__('发送验证码')}}"
                data-message-required="{{__('请输入手机号和验证码')}}"
                class="send-sms-captcha rounded py-3 bg-blue-600 text-white text-center text-base hover:bg-blue-500">
            {{__('发送验证码')}}
        </button>
    </div>
</div>