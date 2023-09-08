<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV493
{

    public static function handle()
    {
        self::renameAppConfig();
    }

    private static function renameAppConfig()
    {
        AppConfig::query()->where('key', 'pay.alipay.ali_public_key')->update([
            'name' => '支付宝公钥',
            'sort' => 30,
            'help' => '',
        ]);
        AppConfig::query()->where('key', 'pay.alipay.private_key')->update([
            'name' => '应用私钥',
            'sort' => 35,
            'help' => '',
        ]);
    }

}
