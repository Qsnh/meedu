<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Player;

use Illuminate\Support\Str;

class TencentKey
{
    protected $key;

    public function __construct()
    {
        $this->key = config('meedu.system.player.tencent_play_key');
    }

    public function url($url)
    {
        $urlInfo = parse_url($url);
        $dir = pathinfo($urlInfo['path'], PATHINFO_DIRNAME) . '/';
        // 默认三个小时
        $t = time() + 3600 * 3;
        $exper = 0;
        $rlimit = 3;
        $us = Str::random(16);
        $sign = md5($this->key . $dir . $t . $exper . $rlimit . $us);
        return sprintf('%s?t=%s&exper=%d&rlimit=%d&us=%s&sign=%s', $url, $t, $exper, $rlimit, $us, $sign);
    }
}
