require('./bootstrap');

$(function () {

    function loginCheck() {
        if (parseInt($('meta[name="user-login-status"]').attr('content')) === 0) {
            window.location.href = '/login';
            return;
        }
    }

    $('body').on('click', '.captcha', function () {
        // 验证码切换
        let src = $(this).attr('src'), now = Date.now();
        if (src.indexOf('?') !== -1) {
            src = src.split('?')[0] + '?t=' + now;
        } else {
            src = src + "?t=" + now;
        }
        $(this).attr('src', src);
    }).on('click', '.send-sms-captcha', function () {
        // 发送短信验证码

        const SMS_CYCLE_TIME = 120;
        var SMS_CURRENT_TIME = 0;

        var imageCaptcha = $('input[name="captcha"]').val();
        var mobile = $('input[name="mobile"]').val();
        if (imageCaptcha === '' || mobile === '') {
            window.flashError('请输入手机号和图形验证码');
            return;
        }
        var token = $('meta[name="csrf-token"]').attr('content');
        $(this).attr('disabled', true);
        $.post('/sms/send', {
            mobile: mobile,
            captcha: imageCaptcha,
            method: $('input[name="sms_captcha_key"]').val(),
            _token: token
        }, res => {
            if (res.code !== 0) {
                $(this).attr('disabled', false);
                window.flashError(res.message);
                $('.captcha').click();
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
    }).on('submit', '.register-form', function () {
        // 注册表单提交验证
        if ($('input[name="agree_protocol"]:checked').length === 0) {
            window.flashError('请同意用户协议和隐私协议');
            return false;
        }
        return true;
    }).on('click', '.message-item', function () {
        // 标记消息已读
        if ($(this).find('.dot .bg-red-500').length === 0) {
            return;
        }

        let id = $(this).attr('data-id');
        let token = $('meta[name="csrf-token"]').attr('content');
        $.post($(this).attr('data-url'), {
            id: id,
            _token: token
        }, res => {
            if (res.code !== 0) {
                flashWarning(res.message);
            } else {
                $(this).find('.dot .bg-red-500').removeClass('bg-red-500').addClass('bg-white');
                $(this).find('.message-item-content').removeClass('text-gray-800').addClass('text-gray-500');
            }
        }, 'json');
    }).on('click', '.btn-read-all-message', function () {
        // 标记消息全部已读
        var token = $('meta[name="csrf-token"]').attr('content');
        var messageSuccess = $(this).attr('data-message-success');
        $.post($(this).attr('data-url'), {
            _token: token
        }, function (res) {
            if (res.code !== 0) {
                flashWarning(res.message);
            } else {
                flashSuccess(messageSuccess);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }
        }, 'json');
    }).on('click', '.btn-like-course', function () {
        // 收藏课程

        loginCheck();

        $.post($(this).attr('data-url'), {
            _token: $('meta[name="csrf-token"]').attr('content')
        }, res => {
            if (res.code !== 0) {
                window.flashError(res.message);
            } else {
                if (res.data === 1) {
                    $(this).removeClass('text-gray-400').addClass('text-blue-600');
                } else {
                    $(this).removeClass('text-blue-600').addClass('text-gray-400');
                }
            }
        }, 'json');
    }).on('click', '.btn-payment-item', function () {
        // 下订单页面 - 支付方式切换
        let sign = $(this).find('img').attr('data-payment');
        $('input[name="payment_sign"]').val(sign);
        $(this).removeClass('border-gray-200').addClass('border-blue-600')
        $(this).siblings().removeClass('border-blue-600').addClass('border-gray-200');
    }).on('click', '.btn-promo-code-check', function () {
        // 邀请码/优惠码校验

        let promoCode = $('input[name="promo_code"]').val();
        if (promoCode.trim().length === 0) {
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
                let total = $('.total-value').attr('data-total');
                let m = total - discount;
                m = m > 0 ? m : 0;
                $('.promo-code-discount-value').text(discount);
                $('.total-value').text(m);
                $('input[name="promo_code_id"]').val(res.data.id);
            } else {
                $('.promo-code-check-info').text(res.message).show();
                $('.promo-code-price').text(0);
                $('.total-value').text($('.total-value').attr('data-total'));
                $('input[name="promo_code_id"]').val('');
            }
        }, 'json');
    }).on('submit', '.create-order-form', function () {
        // 下订单检测

        let payment = $('input[name="payment_sign"]').val();
        if (payment === '') {
            flashWarning($(this).attr('data-message-payment-required'));
            return false;
        }
        return true;
    }).on('click', '.tabs-item', function () {
        // tabs切换

        $(this).addClass('active').siblings().removeClass('active');
        var index = parseInt($(this).attr('data-index'));
        var marginMap = {
            0: 30,
            1: 132,
            2: 236,
            3: 343,
        }
        $(this).parent().find('.scroll-banner').css('transform', 'translateX(' + marginMap[index] + 'px)');

        var dom = $(this).attr('data-dom');
        if (dom) {
            $('.' + dom).show().siblings().hide();
        }
    }).on('click', '.btn-submit-comment', function () {
        // 提交评论

        loginCheck();

        var content = $('textarea[name="comment-content"]').val();
        if (content.trim().length === 0) {
            return;
        }

        let token = $('meta[name="csrf-token"]').attr('content');

        $.post($(this).attr('data-url'), {
            _token: token,
            content: content,
        }, function (res) {
            if (res.code === 0) {
                flashSuccess('成功');
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                flashError(res.message);
            }
        }, 'json');
    }).on('click', '.vod-chapter-item', function () {
        var isHidden = $(this).siblings().is(':hidden');
        if (isHidden) {
            $(this).find('.arrow svg').css('transform', 'rotate(-180deg)')
        } else {
            $(this).find('.arrow svg').css('transform', 'rotate(0deg)')
        }
        $(this).siblings().toggle(200);
    }).on('click', '.btn-nickname-change', function () {
        var nickname = $('input[name="nickname"]').val();
        if (nickname.trim().length === 0) {
            flashWarning($(this).attr('data-message-required'));
            return;
        }

        var messageSuccess = $(this).attr('data-message-success');
        $.post($(this).attr('data-url'), {
            _token: $('meta[name="csrf-token"]').attr('content'),
            nick_name: nickname
        }, function (res) {
            if (res.code === 0) {
                flashSuccess(messageSuccess);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                flashError(res.message);
            }
        }, 'json');
    }).on('click', '.btn-avatar-change', function () {
        var that = this;

        $('input[name="avatar"]').unbind('change');
        $('input[name="avatar"]').change(function (e) {
            if (e.target.files.length === 0) {
                flashWarning($(that).attr('data-message-required'));
                return;
            }
            let formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

            var messageSuccess = $(that).attr('data-message-success');

            $.ajax({
                url: $(that).attr('data-url'),
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    Accept: "application/json; charset=utf-8"
                },
            }).done(res => {
                if (res.code !== 0) {
                    flashError(res.message);
                } else {
                    // 成功跳转到登录界面
                    flashSuccess(messageSuccess);
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            });
        });
        $('input[name="avatar"]').click();
    }).on('click', '.btn-image-upload', function () {
        var message = {
            required: $(this).attr('data-message-required'),
            success: $(this).attr('data-message-success')
        };

        var inputName = $(this).attr('data-input-name');
        var fileInputName = $(this).attr('data-file-input-name');

        var url = $(this).attr('data-url');

        $(`input[name="${fileInputName}"]`).unbind('change');

        $(`input[name="${fileInputName}"]`).change(function (e) {
            if (e.target.files.length === 0) {
                flashWarning(message.required);
                return;
            }

            let formData = new FormData();
            formData.append("file", e.target.files[0]);
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));

            $.ajax({
                url: url,
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    Accept: "application/json; charset=utf-8"
                },
            }).done(res => {
                if (res.code !== 0) {
                    flashError(res.message);
                } else {
                    $(`input[name="${inputName}"]`).val(res.data.url);
                    // preview
                    var previewDom = '.' + inputName + '-preview';
                    if ($(previewDom).find('img').length === 0) {
                        $(previewDom).html(`<img src="${res.data.url}" width="200" class="object-cover rounded mb-3">`)
                    } else {
                        $(previewDom).find('img').attr('src', res.data.url);
                    }
                }
            });
        });
        $(`input[name="${fileInputName}"]`).click();
    }).on('click', '.btn-profile-change', function () {
        var address = [];
        var province = $('select[name="china-province"]').val();
        if (province) {
            address.push(province);
            var city = $('select[name="china-city"]').val();
            if (city) {
                address.push(city);
                var area = $('select[name="china-area"]').val();
                if (area) {
                    address.push(area);
                    var street = $('input[name="china-street"]').val();
                    if (street) {
                        address.push(street);
                    }
                }
            }
        }

        var form = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            real_name: $('input[name="real_name"]').val(),
            age: $('input[name="age"]').val(),
            gender: $('select[name="gender"]').val(),
            profession: $('input[name="profession"]').val(),
            birthday: $('input[name="birthday"]').val(),
            graduated_school: $('input[name="graduated_school"]').val(),
            diploma: $('input[name="diploma"]').val(),
            id_number: $('input[name="id_number"]').val(),
            id_frontend_thumb: $('input[name="id_frontend_thumb"]').val(),
            id_backend_thumb: $('input[name="id_backend_thumb"]').val(),
            id_hand_thumb: $('input[name="id_hand_thumb"]').val(),
            address: address.join('-'),
        };

        $.post($(this).attr('data-url'), form, function (res) {
            if (res.code === 0) {
                flashSuccess($(this).attr('data-message-success'));
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                flashError(res.message);
            }
        }, 'json');
    }).on('click', '.btn-submit-withdraw', function () {
        var account = $('input[name="account"]').val();
        var name = $('input[name="name"]').val();
        var total = parseInt($('input[name="total"]').val());

        if (account.length === 0 || name.length === 0 || total <= 0) {
            flashError($(this).attr('data-message-required'));
            return;
        }

        var messageSuccess = $(this).attr('data-message-success');

        $.post($(this).attr('data-url'), {
            _token: $('meta[name="csrf-token"]').attr('content'),
            total: total,
            channel: {
                name: 'Alipay',
                username: name,
                account: account
            }
        }, function (res) {
            if (res.code === 0) {
                flashSuccess(messageSuccess);
                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            } else {
                flashError(res.message);
            }
        }, 'json');
    })
});
