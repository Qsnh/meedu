<div class="form-item">
    <input type="text" name="mobile" value="{{old('mobile')}}" class="form-input-item" placeholder="手机号" required>
</div>
<div class="form-item">
    <input type="text" name="captcha" class="form-input-item" placeholder="图形验证码" required>
    <div class="image-captcha">
        <img src="{{ captcha_src() }}" class="captcha" width="70" height="28">
    </div>
</div>
<div class="form-item">
    <input type="text" name="sms_captcha" class="form-input-item" placeholder="短信验证码" required>
    <input type="hidden" name="sms_captcha_key" value="{{$smsCaptchaKey ?? ''}}">
    <div class="send-sms-captcha-box">
        <button class="send-sms-captcha" type="button">发送</button>
    </div>
</div>