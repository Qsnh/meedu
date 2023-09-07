<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeToV493
{

    public static function handle()
    {
        self::removeConfig();
    }

    private static function removeConfig()
    {
        AppConfig::query()->whereIn('key', [
            'pay.alipay.private_key',
        ])->delete();
    }

}
