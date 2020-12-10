require('./bootstrap');

window.showAuthBox = function ($box) {
    $('#auth-box-content').html($('#' + $box).html());
    $('.auth-box').show();
};

$(function () {
    $('.user-avatar').mouseover(function () {
        $(this).addClass('show');
        $(this).find('a').attr('aria-expanded', true);
        $(this).find('.dropdown-menu').addClass('show');
    }).mouseout(function () {
        $(this).removeClass('show');
        $(this).find('a').attr('aria-expanded', false);
        $(this).find('.dropdown-menu').removeClass('show');
    });

    $('body').on('click', '.close-auth-box', function () {
        $('.auth-box').hide();
    }).on('click', '.login-password-button', function () {
        let mobile = $('input[name="mobile"]').val();
        let password = $('input[name="password"]').val();
        let remember = $('input[name="remember"]:checked').val();
        if (mobile === '' || password === '') {
            $('.auth-box-errors').text('请输入手机号和密码');
            return false;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            mobile: mobile,
            password: password,
            _token: token
        };
        if (typeof remember !== "undefined") {
            data.remember = 1;
        }
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                window.location.reload();
            }
        }, 'json');
    }).on('click', '.captcha', function () {
        let src = $(this).attr('src'), now = Date.now();
        if (src.indexOf('?') !== -1) {
            src = src.split('?')[0] + '?t=' + now;
        } else {
            src = src + "?t=" + now;
        }
        $(this).attr('src', src);
    }).on('click', '.send-sms-captcha', function () {

        const SMS_CYCLE_TIME = 120;
        let SMS_CURRENT_TIME = 0;

        let imageCaptcha = $('input[name="captcha"]').val();
        let mobile = $('input[name="mobile"]').val();
        if (imageCaptcha === '' || mobile === '') {
            $('.auth-box-errors').text('请输入手机号和图形验证码');
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
                $('.auth-box-errors').text(res.message);
                $('.captcha').click();
                return;
            }
            $('.auth-box-errors').text('');

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
    }).on('click', '.login-mobile-button', function () {
        let mobile = $('input[name="mobile"]').val();
        let smsCaptcha = $('input[name="sms_captcha"]').val();
        let remember = $('input[name="remember"]:checked').val();
        if (mobile === '' || smsCaptcha === '') {
            $('.auth-box-errors').text('请输入手机号和短信验证码');
            return false;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            mobile: mobile,
            sms_captcha: smsCaptcha,
            _token: token,
            sms_captcha_key: 'mobile_login'
        };
        if (typeof remember !== "undefined") {
            data.remember = 1;
        }
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                window.location.reload();
            }
        }, 'json');
    }).on('click', '.password-reset-button', function () {
        let mobile = $('input[name="mobile"]').val();
        let password = $('input[name="password"]').val();
        let passwordConfirm = $('input[name="password_confirmation"]').val();
        let smsCaptcha = $('input[name="sms_captcha"]').val();
        if (mobile === '' || password === '' || passwordConfirm === '') {
            $('.auth-box-errors').text('请输入手机号和密码');
            return false;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            mobile: mobile,
            password: password,
            password_confirmation: passwordConfirm,
            _token: token,
            sms_captcha: smsCaptcha,
            sms_captcha_key: 'password_reset'
        };
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('密码重置成功');
                showAuthBox('login-box');
            }
        }, 'json');
    }).on('click', '.register-button', function () {
        let mobile = $('input[name="mobile"]').val();
        let password = $('input[name="password"]').val();
        let smsCaptcha = $('input[name="sms_captcha"]').val();
        let protocol = $('input[name="agree_protocol"]:checked').val();
        if (mobile === '' || password === '') {
            $('.auth-box-errors').text('请输入手机号，密码');
            return false;
        }
        if (typeof protocol === "undefined") {
            flashWarning("请同意协议");
            return;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            mobile: mobile,
            password: password,
            _token: token,
            sms_captcha: smsCaptcha,
            sms_captcha_key: 'register'
        };
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('注册成功');
                showAuthBox('login-box');
            }
        }, 'json');
    }).on('click', '.mobile-bind-button', function () {
        let mobile = $('input[name="mobile"]').val();
        let smsCaptcha = $('input[name="sms_captcha"]').val();
        if (mobile === '' || smsCaptcha === '') {
            $('.auth-box-errors').text('请输入手机号和短信验证码');
            return false;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            mobile: mobile,
            _token: token,
            sms_captcha: smsCaptcha,
            sms_captcha_key: 'mobile_bind'
        };
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('绑定成功');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }, 'json');
    }).on('click', '.password-change-button', function () {
        let oldPassword = $('input[name="old_password"]').val();
        let newPassword = $('input[name="new_password"]').val();
        let newPasswordConfirmation = $('input[name="new_password_confirmation"]').val();
        if (oldPassword === '' || newPassword === '' || newPasswordConfirmation === '') {
            $('.auth-box-errors').text('请输入原密码和新密码');
            return false;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            _token: token,
            old_password: oldPassword,
            new_password: newPassword,
            new_password_confirmation: newPasswordConfirmation
        };
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('密码修改成功');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }, 'json');
    }).on('click', '.avatar-change-button', function () {
        let file = $('input[name="file"]')[0].files[0];
        if (typeof file === 'undefined') {
            $('.auth-box-errors').text('请选择头像');
            return false;
        }
        $('.auth-box-errors').text('');
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let formData = new FormData();
        formData.append("file", file);
        formData.append("_token", token);
        $.ajax({
            url: $('.login-box').attr('action'),
            type: 'POST',
            cache: false,
            data: formData,
            processData: false,
            contentType: false
        }).done(res => {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('头像更换成功');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        });
    }).on('click', '.nickname-change-button', function () {
        let nickname = $('input[name="nick_name"]').val();
        if (nickname === '') {
            $('.auth-box-errors').text('请输入昵称');
            return false;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            _token: token,
            nick_name: nickname
        };
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('修改成功');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }, 'json');
    }).on('click', '.member-message-item', function () {
        if ($(this).find('.red-dot').length === 0) {
            return;
        }
        let id = $(this).attr('data-id');
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post('/member/ajax/message/read', {
            id: id,
            _token: token
        }, res => {
            if (res.code !== 0) {
                $(this).disabled = false;
                flashWarning(res.message);
            } else {
                $(this).find('.red-dot').hide();
                $(this).find('.member-message-unread').addClass('member-message-read').removeClass('member-message-unread').text('已读');
            }
        }, 'json');
    }).on('click', '.invite-balance-withdraw-button', function () {
        let total = $('input[name="total"]').val();
        let channel_name = $('select[name="channel[name]"]').val();
        let channel_username = $('input[name="channel[username]"]').val();
        let channel_account = $('input[name="channel[account]"]').val();
        if (channel_name === '' || channel_username === '' || channel_account === '') {
            $('.auth-box-errors').text('请输入相应信息');
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
        $.post($('.login-box').attr('action'), data, function (res) {
            if (res.code !== 0) {
                $(this).disabled = false;
                $('.auth-box-errors').text(res.message);
            } else {
                // 成功跳转到登录界面
                flashSuccess('提现提交成功');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }, 'json');
    }).on('click', '.like-button', function () {
        let isLogin = parseInt($(this).attr('data-login'));
        let url = $(this).attr('data-url');
        if (isLogin === 0) {
            showAuthBox('login-box');
            return;
        }
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {
            _token: token
        }, res => {
            if (res.code !== 0) {
                flashError(res.message);
            } else {
                if (res.data === 1) {
                    $(this).find('span').text('已收藏');
                    $(this).find('img').attr('src', '/images/icons/like-hover.png');
                } else {
                    $(this).find('span').text('收藏课程');
                    $(this).find('img').attr('src', '/images/icons/like.png');
                }
            }
        }, 'json');
    }).on('click', '.login-auth', function () {
        let pathname = window.location.pathname;
        if (pathname === '/login') {
            return false;
        }
        if (pathname === '/register' || pathname === '/password/reset') {
            return true;
        }
        let loginStatus = parseInt($(this).attr('data-login'));
        if (loginStatus === 0) {
            showAuthBox('login-box');
            return false;
        }
        return true;
    }).on('click', '.comment-button', function () {
        let isLogin = parseInt($(this).attr('data-login'));
        if (isLogin === 0) {
            showAuthBox('login-box');
            return;
        }
        let input = $(this).attr('data-input');
        let url = $(this).attr('data-url');
        let content = $(`textarea[name=${input}]`).val();
        if (content.length === 0) {
            flashWarning('请输入评论内容');
            return;
        }
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post(url, {
            _token: token,
            content: content
        }, function (res) {
            if (res.code !== 0) {
                flashError(res.message)
            } else {
                let data = res.data;
                let html = `
<div class="comment-list-item">
                                <div class="comment-user-avatar">
                                    <img src="${data.user.avatar}" width="70" height="70">
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
    }).on('click', '.payment-item', function () {
        let sign = $(this).find('img').attr('data-payment');
        $('input[name="payment_sign"]').val(sign);
        $(this).addClass('selected').siblings().removeClass('selected');
    }).on('click', '.promo-code-check-button', function () {
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
                let total = $('.total-price-val').attr('data-total');
                let m = total - discount;
                m = m > 0 ? m : 0;
                $('.promo-code-info').text('此码有效，已抵扣' + discount + '元').show();
                $('.promo-code-price').text(discount);
                $('.total-price-val').text(m);
                $('input[name="promo_code_id"]').val(res.data.id);
            } else {
                $('.promo-code-info').text(res.message).show();
                $('.promo-code-price').text(0);
                $('.total-price-val').text($('.total-price-val').attr('data-total'));
                $('input[name="promo_code_id"]').val('');
            }
        }, 'json');
    }).on('submit', '.create-order-form', function () {
        let payment = $('input[name="payment_sign"]').val();
        if (payment === '') {
            flashWarning('请选择支付方式');
            return false;
        }
    }).on('click', '.role-list-item', function () {
        let url = $(this).attr('data-url');
        $(this).addClass('active').siblings().removeClass('active');
        $('.role-join-button').attr('href', url);
    }).on('click', '.course-show-menu-item', function () {
        let page = $(this).attr('data-page');
        if (!page) {
            return true;
        }
        let c = '.' + page;
        if ($('body').find(c).length === 0) {
            return true;
        }
        $('.' + page).show(200).siblings().hide(200);
        $(this).parent().addClass('active').siblings().removeClass('active');
        return false;
    }).on('click', '.video-show-page-item', function () {
        let page = $(this).attr('data-page');
        if (!page) {
            return true;
        }
        let c = '.' + page;
        if ($('body').find(c).length === 0) {
            return true;
        }
        $('.' + page).show(200).siblings().hide(200);
        $(this).parent().addClass('active').siblings().removeClass('active');
        return false;
    }).on('click', '.show-select-payment-model', function () {
        $('.select-payment-model').show();
    }).on('click', '.close-select-payment-model', function () {
        $('.select-payment-model').hide();
    }).on('click', '.course-chapter-title', function () {
        let dom = $(this).attr('data-dom');
        $('.' + dom).toggle();
        let iconDom = $(this).find('i');
        if ($(iconDom).hasClass('fa-angle-down')) {
            $(iconDom).removeClass('fa-angle-down').addClass('fa-angle-up');
        } else {
            $(iconDom).removeClass('fa-angle-up').addClass('fa-angle-down');
        }
    });
});
