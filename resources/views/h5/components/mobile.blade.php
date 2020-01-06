<div class="weui-cell">
    <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
    <div class="weui-cell__bd">
        <input type="text" name="mobile" class="weui-input" value="{{old('mobile')}}" placeholder="填写手机号">
    </div>
</div>
<div class="weui-cell weui-cell_vcode">
    <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
    <div class="weui-cell__bd">
        <input name="sms_captcha" class="weui-input" type="text" placeholder="验证码">
        <input type="hidden" name="sms_captcha_key" value="{{$scene}}">
    </div>
    <div class="weui-cell__ft">
        <button type="button" class="weui-btn weui-btn_default weui-vcode-btn getSmsCode">
            获取验证码
        </button>
    </div>
</div>

<div id="imageCaptchaDialog" style="display: none;">
    <div class="weui-mask"></div>
    <div class="weui-half-screen-dialog">
        <div class="weui-half-screen-dialog__hd">
            <div class="weui-half-screen-dialog__hd__main">
                <strong class="weui-half-screen-dialog__title">请输入验证码</strong>
            </div>
        </div>
        <div class="weui-half-screen-dialog__bd">
            <div class="weui-cell">
                <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                <div class="weui-cell__bd">
                    <input type="text" name="image_captcha" class="weui-input" placeholder="验证码">
                </div>
            </div>
            <br>
            <p style="text-align: right"><img src="{{ captcha_src() }}" class="captcha" width="120" height="36"></p>
        </div>
        <div class="weui-half-screen-dialog__ft">
            <button type="button" class="weui-btn weui-btn_default imageCaptchaDialogCancel">取消</button>
            <button type="button" class="weui-btn weui-btn_primary imageCaptchaDialogConfirm">确认</button>
        </div>
    </div>
</div>

<script>
    var SMS_CYCLE_TIME = 120;
    var SMS_CURRENT_TIME = 0;

    $(function () {
        $('.getSmsCode').click(function () {
            $('#imageCaptchaDialog').show(200);
        });
        $('.imageCaptchaDialogCancel').click(function () {
            $('#imageCaptchaDialog').hide(200);
        });
        $('#imageCaptchaDialog .weui-mask').click(function () {
            $('#imageCaptchaDialog').hide(200);
        });

        $('.captcha').click(function () {
            $('input[name="captcha"]').val('');
            $(this).attr('src' , $(this).attr('src') + '?' + Math.random());
        });

        $('.imageCaptchaDialogConfirm').click(function () {
            var mobile = $('input[name="mobile"]').val();
            var imageCaptcha = $('input[name="image_captcha"]').val();
            if (mobile.length === 0) {
                alert('请输入手机号');
                return;
            }
            if (imageCaptcha.length === 0) {
                alert('请输入验证码');
                return;
            }

            $.post('{{ route('sms.send') }}', {
                mobile: mobile,
                captcha: imageCaptcha,
                method: $('input[name="sms_captcha_key"]').val(),
                _token: '{{ csrf_token() }}'
            }, function (res) {
                if (res.code !== 0) {
                    alert(res.message);
                    $('.captcha').click();
                    $('input[name="image_captcha"]').val('');
                    return false;
                }

                $('.imageCaptchaDialogCancel').click();
                $('input[name="image_captcha"]').val('');
                $('.captcha').click();
                SMS_CURRENT_TIME = SMS_CYCLE_TIME;
                var smsInterval = setInterval(function () {
                    if (SMS_CURRENT_TIME <= 1) {
                        $('.getSmsCode').text('获取验证码');
                        $('.getSmsCode').removeAttr('disabled');
                        clearInterval(smsInterval);
                        return;
                    }
                    SMS_CURRENT_TIME = SMS_CURRENT_TIME - 1;
                    $('.getSmsCode').text(SMS_CURRENT_TIME + 's');
                    $('.getSmsCode').attr('disabled', true);
                }, 1000);

            }, 'json');
        });
    });
</script>