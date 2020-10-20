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
        let src = $(this).attr('src'), now = Date.now();
        if (src.indexOf('?') !== -1) {
            src = src.split('?')[0] + '?t=' + now;
        } else {
            src = src + "?t=" + now
        }
        $(this).attr('src', src);
        $('input[name="captcha"]').val('');
    }).on('tap', '.send-sms-captcha', function () {
        if (window.SMS_LOCK === true) {
            return;
        }

        const SMS_CYCLE_TIME = 120;
        let SMS_CURRENT_TIME = 0;

        let imageCaptcha = $('input[name="captcha"]').val();
        let mobile = $('input[name="mobile"]').val();
        if (imageCaptcha === '' || mobile === '') {
            flashWarning('请输入手机号和图形验证码');
            return;
        }
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post('/sms/send', {
            mobile: mobile,
            captcha: imageCaptcha,
            method: $('input[name="sms_captcha_key"]').val(),
            _token: token
        }, res => {
            if (res.code !== 0) {
                window.SMS_LOCK = false;
                flashError(res.message);
                $('.captcha').tap();
                return;
            }

            window.SMS_LOCK = true;

            SMS_CURRENT_TIME = SMS_CYCLE_TIME;
            var smsInterval = setInterval(() => {
                if (SMS_CURRENT_TIME <= 1) {
                    $(this).text('发送验证码');
                    clearInterval(smsInterval);
                    window.SMS_LOCK = false;
                    return;
                }
                SMS_CURRENT_TIME = SMS_CURRENT_TIME - 1;
                $(this).text(SMS_CURRENT_TIME + 's');
                window.SMS_LOCK = true;
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
    }).on('tap', '.mobile-login-button', function () {
        let url = $(this).attr('data-url');
        let mobile = $('.mobile-login-form input[name="mobile"]').val();
        let smsCode = $('.mobile-login-form input[name="sms_captcha"]').val();
        let smsKey = $('.mobile-login-form input[name="sms_captcha_key"]').val();
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {
            _token: token,
            mobile: mobile,
            sms_captcha: smsCode,
            sms_captcha_key: smsKey
        }, function (res) {
            if (res.code !== 0) {
                flashError(res.message);
                $('.mobile-login-form input[name="sms_captcha"]').val('');
                $('.captcha').tap();
                return;
            }
            window.location = res.data.redirect_url;
        }, 'json');
    }).on('tap', '.comment-button', function () {
        let input = $(this).attr('data-input');
        let isLogin = parseInt($(this).attr('data-login'));
        let url = $(this).attr('data-url');
        let loginUrl = $(this).attr('data-login-url');
        let content = $(`textarea[name=${input}]`).val();
        let token = $('meta[name="csrf-token"]').attr('content');
        if (isLogin === 0) {
            window.location = loginUrl;
            return;
        }
        if (content.length < 6) {
            flashWarning('评论内容最少6个字');
            return;
        }
        $.post(url, {
            _token: token,
            content: content,
        }, function (res) {
            if (res.code !== 0) {
                flashError(res.message);
            } else {
                flashSuccess('评论成功');
                let data = res.data;
                let html = `
<div class="comment-list-item">
                                <div class="comment-user-avatar">
                                    <img src="${data.user.avatar}" width="44" height="44">
                                </div>
                                <div class="comment-content-box">
                                    <div class="comment-user-nickname">${data.user.nick_name}</div>
                                    <div class="comment-content">
                                    ${data.content}
                                    </div>
                                    <div class="comment-info">
                                        <span class="comment-createAt">${data.created_at}</span>
                                    </div>
                                </div>
                            </div>
                    `;
                $(`textarea[name=${input}]`).val('');
                $('.comment-list-box').prepend(html);
            }
        }, 'json');
    }).on('tap', '.course-info-menu .menu-item', function () {
        $('.course-content-tab-item').hide();
        $('.' + $(this).attr('data-dom')).show();
        $(this).addClass('active').siblings().removeClass('active');
    }).on('tap', '.videos-count', function () {
        let dom = $(this).attr('data-dom');
        $('.' + dom).toggle();
        let iconDom = $(this).find('i');
        if ($(iconDom).hasClass('fa-angle-down')) {
            $(iconDom).removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $(iconDom).removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    }).on('tap', '.invite-balance-withdraw-button', function () {
        let total = $('input[name="total"]').val();
        let channel_name = $('select[name="channel[name]"]').val();
        let channel_username = $('input[name="channel[username]"]').val();
        let channel_account = $('input[name="channel[account]"]').val();
        if (channel_name === '' || channel_username === '' || channel_account === '') {
            window.flashError('请输入信息');
            return false;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            _token: token,
            total: total,
            channel: {
                name: channel_name,
                username: channel_username,
                account: channel_account
            }
        };
        $.post($(this).attr('data-action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                window.flashError(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('提现提交成功');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }, 'json');
    }).on('tap', '.invite-balance-withdraw-box-toggle', function () {
        $('.balance-withdraw-submit-box-shadow').toggle();
    });
});