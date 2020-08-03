<div class="form-group">
    <label>手机号</label>
    <input type="text" name="mobile" class="form-control" placeholder="手机号" required>
</div>
<div class="form-group">
    <label>验证码</label>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <input type="text" name="captcha" placeholder="验证码" class="form-control" required>
                <div class="input-group-append">
                    <img src="{{ captcha_src() }}" class="captcha" width="120" height="48">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <label>手机验证码</label>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <input type="text" name="sms_captcha" placeholder="手机验证码" class="form-control" required>
                <input type="hidden" name="sms_captcha_key" value="{{$smsCaptchaKey ?? ''}}">
                <div class="input-group-append">
                    <button type="button" style="width: 120px;" class="send-sms-captcha btn btn-primary">发送验证码</button>
                </div>
            </div>
        </div>
    </div>
</div>