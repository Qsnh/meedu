<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Services\Base\Model\AppConfig;

class UpgradeToV454
{
    public static function handle()
    {
        self::appConfigAppUrlUpdate();
        self::appConfigH5UrlUpdate();
        self::appConfigPcUrlUpdate();
    }

    protected static function appConfigAppUrlUpdate()
    {
        AppConfig::query()
            ->where('key', 'app.url')
            ->update([
                'name' => 'API访问地址',
                'help' => '请填写API访问地址，需携带http://或https://协议',
            ]);
    }

    protected static function appConfigPcUrlUpdate()
    {
        AppConfig::query()
            ->where('key', 'meedu.system.pc_url')
            ->update([
                'name' => 'PC访问地址',
                'help' => '请填写PC界面访问地址，需携带http://或https://协议',
            ]);
    }

    protected static function appConfigH5UrlUpdate()
    {
        AppConfig::query()
            ->where('key', 'meedu.system.h5_url')
            ->update([
                'name' => 'H5访问地址',
                'help' => '请填写H5界面访问地址，需携带http://或https://协议',
            ]);
    }
}
