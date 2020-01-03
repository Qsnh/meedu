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

class FrontendConstant
{
    const RENDER_MARKDOWN = 'markdown';
    const RENDER_HTML = 'html';

    const PAYMENT_SCENE_PC = 'pc';
    const PAYMENT_SCENE_WECHAT_MINI = 'wechatmini';
    const PAYMENT_SCENE_H5 = 'h5';
    const PAYMENT_SCENE_WECHAT_OPEN = 'wechat';

    const ORDER_PAID = 9;

    const YES = 1;

    const PAYMENT_WECHAT_PAY_CACHE_KEY = 'wechat_remote_order_%s';
    const PAYMENT_WECHAT_PAY_CACHE_EXPIRE = 600;

    const JSON_ERROR_CODE = 2;

    const H5 = 'h5';
}
