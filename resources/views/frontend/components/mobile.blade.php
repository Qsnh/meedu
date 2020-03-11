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

<script>
    var SMS_CYCLE_TIME = 120;
    var SMS_CURRENT_TIME = 0;
    $(function () {
        $('.captcha').click(function () {
            $('input[name="captcha"]').val('');
            $(this).attr('src', $(this).attr('src') + '?' + Math.random());
        });
        $('.send-sms-captcha').click(function () {
            var captcha = $('input[name="captcha"]').val();
            var mobile = $('input[name="mobile"]').val();
            if (captcha === '' || mobile === '') {
                alert('请输入图形验证码或手机号');
                return false;
            }

            $.post('{{ route('sms.send') }}', {
                mobile: mobile,
                captcha: captcha,
                method: '{{$smsCaptchaKey}}',
                _token: '{{ csrf_token() }}'
            }, function (res) {
                if (res.code !== 0) {
                    alert(res.message);
                    $('.captcha').click();
                    return false;
                }

                SMS_CURRENT_TIME = SMS_CYCLE_TIME;
                var smsInterval = setInterval(function () {
                    if (SMS_CURRENT_TIME <= 1) {
                        $('.send-sms-captcha').text('发送验证码');
                        $('.send-sms-captcha').attr('disabled', false);
                        clearInterval(smsInterval);
                        return;
                    }
                    SMS_CURRENT_TIME = SMS_CURRENT_TIME - 1;
                    $('.send-sms-captcha').text(SMS_CURRENT_TIME + 's');
                    $('.send-sms-captcha').attr('disabled', true);
                }, 1000);

            }, 'json');
        });
    });
</script>