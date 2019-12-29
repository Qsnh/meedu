<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Constant;

class ApiV2Constant
{
    const PARAMS_ERROR = '参数错误';
    const PLEASE_INPUT_IMAGE_CAPTCHA = '请输入图片验证码';
    const IMAGE_CAPTCHA_ERROR = '图片验证码错误';

    const USER_MOBILE_NOT_EXISTS = '手机号不存在';
    const MOBILE_HAS_EXISTS = '手机号已经存在';
    const MOBILE_OR_PASSWORD_ERROR = '手机号不存在或密码错误';

    const SMS_CODE_EXPIRE = 60;
}
