require('./bootstrap')

$(function () {
    $('.course-menu-item').click(function () {
        let page = $(this).attr('data-page');
        $('.' + page).show().siblings().hide();
        $(this).addClass('active').siblings().removeClass('active');
    });
    $('body').on('click', '.payment-item', function () {
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
                $('.promo-code-info').text('此邀请码有效，已抵扣' + discount + '元').show();
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
    });
});