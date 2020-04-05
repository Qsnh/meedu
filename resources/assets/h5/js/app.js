require('./bootstrap')

$(function () {
    $('.course-menu-item').tap(function () {
        let page = $(this).attr('data-page');
        $('.' + page).show().siblings().hide();
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('body').on('tap', '.promo-code-check-button', function () {
        let promoCode = $('input[name="promo_code"]').val();
        if (promoCode === '') {
            return;
        }
        let url = $(this).attr('data-url');
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {
            promo_code: promoCode,
            _token: token,
        }, function (res) {
            if (res.code === 0) {
                let discount = res.data.discount;
                let total = $('.total-price').attr('data-total');
                let m = total - discount;
                m = m > 0 ? m : 0;
                $('.promo-code-info').text('此邀请码有效，已抵扣' + discount + '元').show();
                $('.promo-code-price-text').text(discount);
                $('.total-price').text(m);
                $('input[name="promo_code_id"]').val(res.data.id);
            } else {
                $('.promo-code-info').text(res.message).show();
                $('.promo-code-price-text').text(0);
                $('.total-price').text($('.total-price').attr('data-total'));
                $('input[name="promo_code_id"]').val('');
            }
        }, 'json');
    }).on('tap', '.captcha', function () {
        let src = $(this).attr('src');
        if (src.indexOf('?') !== -1) {
            src = src + "&1";
        } else {
            src = src + "?" + Date.now()
        }
        $(this).attr('src', src);
        $('input[name="captcha"]').val('')
    }).on('tap', '.send-sms-captcha', function () {

        const SMS_CYCLE_TIME = 120;
        let SMS_CURRENT_TIME = 0;

        let imageCaptcha = $('input[name="captcha"]').val();
        let mobile = $('input[name="mobile"]').val();
        if (imageCaptcha === '' || mobile === '') {
            flashWarning('请输入手机号和图形验证码');
            return;
        }
        let token = $('meta[name="csrf-token"]').attr('content');
        $(this).attr('disabled', true);
        $.post('/sms/send', {
            mobile: mobile,
            captcha: imageCaptcha,
            method: $('input[name="sms_captcha_key"]').val(),
            _token: token
        }, res => {
            if (res.code !== 0) {
                $(this).attr('disabled', false);
                flashError(res.message);
                $('.captcha').tap();
                return;
            }

            SMS_CURRENT_TIME = SMS_CYCLE_TIME;
            var smsInterval = setInterval(() => {
                if (SMS_CURRENT_TIME <= 1) {
                    $(this).text('发送验证码');
                    $(this).attr('disabled', false);
                    clearInterval(smsInterval);
                    return;
                }
                SMS_CURRENT_TIME = SMS_CURRENT_TIME - 1;
                $(this).text(SMS_CURRENT_TIME + 's');
                $(this).attr('disabled', true);
            }, 1000);

        }, 'json');
    }).on('tap', '.show-buy-course-model', function () {
        $('.buy-course-model').show();
    }).on('tap', '.buy-course-model .close', function () {
        $('.buy-course-model').hide();
    }).on('tap', '.role-item', function () {
        $(this).addClass('active').siblings().removeClass('active');
        $('.role-subscribe-button').attr('href', $(this).attr('data-url'));
    }).on('tap', '.payment-item', function () {
        $(this).addClass('active').siblings().removeClass('active');
        $('input[name="payment_sign"]').val($(this).attr('data-payment'));
    }).on('tap', '.pay-button', function () {
        $('.create-order-form').submit();
    }).on('submit', '.create-order-form', function () {
        let paymentSign = $('input[name="payment_sign"]').val();
        if (paymentSign.length === 0) {
            flashWarning('请选择支付方式');
            return false;
        }
    })
});