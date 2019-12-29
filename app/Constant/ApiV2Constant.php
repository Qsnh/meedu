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
    const PARAMS_ERROR = 'params error';
    const PLEASE_INPUT_IMAGE_CAPTCHA = 'image_captcha.required';
    const IMAGE_CAPTCHA_ERROR = 'image_captcha_error';

    const USER_MOBILE_NOT_EXISTS = 'mobile not exists';
    const MOBILE_HAS_EXISTS = 'mobile has exists';
    const MOBILE_OR_PASSWORD_ERROR = 'mobile not exists or password error';
    const MOBILE_CODE_ERROR = 'mobile code error';

    const SMS_CODE_EXPIRE = 60;
    const MOBILE_CODE_CACHE_KEY = 'm:%s';
}
