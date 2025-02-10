<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV4917
{

    public static function handle()
    {
        self::deleteSomeConfigItems();
    }

    private static function deleteSomeConfigItems()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.mp_wechat.aes_key',
                'meedu.mp_wechat.enabled_share',
            ])
            ->delete();
    }

}
