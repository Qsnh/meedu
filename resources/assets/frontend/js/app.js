/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });

$(function () {
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
        let src = $(this).attr('src');
        if (src.indexOf('?') !== -1) {
            src = src + "&1";
        } else {
            src = src + "?" + Date.now()
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
        let nick_name = $('input[name="nick_name"]').val();
        let password = $('input[name="password"]').val();
        let passwordConfirm = $('input[name="password_confirmation"]').val();
        let smsCaptcha = $('input[name="sms_captcha"]').val();
        let protocol = $('input[name="agree_protocol"]:checked').val();
        if (mobile === '' || nick_name === '' || password === '' || passwordConfirm === '') {
            $('.auth-box-errors').text('请输入昵称，手机号，密码');
            return false;
        }
        if (typeof protocol === "undefined") {
            flashWarning("请同意用户协议");
            return;
        }
        $(this).disabled = true;
        let token = $('meta[name="csrf-token"]').attr('content');
        let data = {
            nick_name: nick_name,
            mobile: mobile,
            password: password,
            password_confirmation: passwordConfirm,
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
    });
});
