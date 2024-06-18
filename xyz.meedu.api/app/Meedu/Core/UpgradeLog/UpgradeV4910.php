<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeV4910
{

    public static function handle()
    {
        AppConfig::query()->where('key', 'meedu.member.protocol')->limit(1)->update(['name' => '注册协议']);
        AppConfig::query()->where('key', 'meedu.member.private_protocol')->limit(1)->update(['name' => '隐私政策']);
    }

}
