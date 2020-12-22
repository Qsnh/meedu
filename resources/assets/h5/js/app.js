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
                $('.promo-code-info').text('此码有效，已抵扣' + discount + '元').show();
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
                flashSuccess('评论提交成功');
                setTimeout(() => {
                    window.location.reload();
                }, 600);
            }
        }, 'json');
    }).on('tap', '.course-info-menu .menu-item', function () {
        $('.course-content-tab-item').hide();
        $('.' + $(this).attr('data-dom')).show();
        $(this).addClass('active').siblings().removeClass('active');
    }).on('tap', '.show-chapter-videos-box', function () {
        let dom = $(this).attr('data-dom');
        // 显示目标dom
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
    }).on('tap', '.back-button', function () {
        if (window.history.length <= 2) {
            window.location.href = $(this).attr('data-url');
        } else {
            window.history.back();
        }
    }).on('tap', '.like-button', function () {
        let isLogin = parseInt($(this).attr('data-login'));
        if (isLogin === 0) {
            window.location.href = $(this).attr('data-login-url');
            return;
        }
        let url = $(this).attr('data-url');
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {
            _token: token
        }, res => {
            if (res.code !== 0) {
                flashError(res.message);
            } else {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    $(this).addClass('active');
                }
            }
        }, 'json');
    }).on('tap', '.show-course-comment-box', function () {
        let isLogin = parseInt($(this).attr('data-login'));
        if (isLogin === 0) {
            window.location.href = $(this).attr('data-login-url');
            return;
        }
        $('.course-comment-input-box-shadow').show();
    }).on('tap', '.close-course-comment-box', function () {
        $('.course-comment-input-box-shadow').hide();
    }).on('tap', '.upload-image-button', function (e) {
        let fileId = '#' + $(this).attr('data-file-id');
        let input = $(this).attr('data-input');
        let viewId = $(this).attr('data-view-id');
        let url = $(this).attr('data-url');
        $(fileId).off('change');
        // 允许上传的图片类型
        var allowTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
        // 1024KB，也就是 1MB
        var maxSize = 2 * 1024 * 1024;
        $(fileId).change(function (e) {
            if (e.target.files.length === 0) {
                flashWarning('请选择图片');
                return;
            }
            let file = e.target.files[0];
            if (allowTypes.indexOf(file.type) === -1) {
                flashWarning('仅支持jpg,jpeg,png,gif图片格式');
                return;
            }
            if (file.size > maxSize) {
                flashWarning('图片大小不能超过2mb');
                return;
            }
            let token = $('meta[name="csrf-token"]').attr('content');
            let formData = new FormData();
            formData.append("file", file);
            formData.append("_token", token);
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                success: res => {
                    if (res.code !== 0) {
                        flashError(res.message);
                    } else {
                        let url = res.data.url;
                        $('input[name=' + input + ']').val(url);
                        let viewDom = '.' + viewId;
                        if ($(viewDom).find('img').length > 0) {
                            $(viewDom).find('img').attr('src', url);
                        } else {
                            $(viewDom).append(`<img src="${url}" width="100" height="100" />`);
                        }
                    }
                },
                error: () => {
                    flashError('上传图片出错')
                }
            })
        });
        $(fileId).click();
        e.preventDefault();
    }).on('tap', '.save-profile-button', function () {
        let inputFile = [
            'real_name', 'age', 'birthday', 'profession', 'address', 'graduated_school',
            'diploma', 'id_number', 'id_frontend_thumb', 'id_backend_thumb', 'id_hand_thumb',
        ];
        let data = {};
        for (let i = 0; i < inputFile.length; i++) {
            let key = inputFile[i];
            data[key] = $(`input[name="${key}"]`).val();
        }
        data['gender'] = $('input[name="gender"]:checked').val();
        data['_token'] = $('meta[name="csrf-token"]').attr('content');
        let url = $(this).attr('data-url');
        $.post(url, data, () => {
            flashSuccess('保存成功');
            setTimeout(() => {
                window.location.reload();
            }, 500);
        });
    });
});