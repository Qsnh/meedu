<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV494
{

    public static function handle()
    {
        self::removeAppConfig();
    }

    private static function removeAppConfig()
    {
        AppConfig::query()
            ->whereIn('key', [
                'meedu.services.amap.key',
            ])
            ->delete();
    }

}
