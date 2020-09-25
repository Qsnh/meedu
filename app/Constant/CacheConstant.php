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

class CacheConstant
{

    // controller 层调用的前缀
    public const PREFIX_C = 'c::';

    // service 层调用的前缀
    public const PREFIX_S = 's::';

    public const USER_VIDEO_WATCH_DURATION = [
        'name' => self::PREFIX_C . 'uvwd:%d',
        'expire' => 1440 * 3,
    ];
}
