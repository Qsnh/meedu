<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Constant;

class BusConstant
{
    public const USER_VERIFY_FACE_TENCENT_STATUS_SUCCESS = 9;
    public const USER_VERIFY_FACE_TENCENT_STATUS_FAIL = 5;

    public const ORDER_STATUS_DEFAULT = 1;
    public const ORDER_STATUS_PAYING = 5;
    public const ORDER_STATUS_CANCEL = 7;
    public const ORDER_STATUS_SUCCESS = 9;

    public const ORDER_PAID_TYPE_DEFAULT = 0;
    public const ORDER_PAID_TYPE_PROMO_CODE = 1;
    public const ORDER_PAID_TYPE_INVITE_BALANCE = 2;

    public const ORDER_GOODS_TYPE_COURSE = 'COURSE';
    public const ORDER_GOODS_TYPE_ROLE = 'ROLE';

    public const PAYMENT_ALIPAY = 'alipay';
    public const PAYMENT_WECHAT = 'wechat';
    public const PAYMENT_HAND_PAY = 'handPay';
}
