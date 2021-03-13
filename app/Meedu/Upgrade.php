<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu;

use App\Services\Base\Model\AppConfig;

class Upgrade
{
    public function run()
    {
        $this->fromV374to4();
    }

    public function fromV374to4()
    {
        // 删除缓存配置
        // 缓存配置给用户带来了极大的困扰，很多用户因为开启了缓存导致一些问题的出现
        // 但是ta们并不认为这是开启缓存导致的
        // 而认为是程序的问题
        AppConfig::query()
            ->whereIn('key', [
                'meedu.system.cache.status',
                'meedu.system.cache.expire',
            ])
            ->delete();

        // 删除github登录
        // 现在大陆服务器访问github经常出现超时的情况
        // 已经严重影响了用户体验
        AppConfig::query()
            ->whereIn('key', [
                'meedu.member.socialite.github.enabled',
                'services.github.client_id',
                'services.github.client_secret',
                'services.github.redirect',
            ])
            ->delete();
    }
}
