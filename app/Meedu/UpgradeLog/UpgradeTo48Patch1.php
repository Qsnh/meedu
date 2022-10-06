<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\UpgradeLog;

use App\Services\Base\Model\AppConfig;
use App\Models\AdministratorPermission;

class UpgradeTo48Patch1
{
    public static function handle()
    {
        self::updateOssAccessKeyId();
        self::updateOssAccessKeySecret();
    }

    public static function updateOssAccessKeyId()
    {
        AppConfig::query()
            ->where('key', 'filesystems.disks.oss.access_id')
            ->update([
                'name' => '阿里云OSS AccessKeyId',
                'key' => 'filesystems.disks.oss.access_key_id'
            ]);
    }
    public static function updateOssAccessKeySecret()
    {
        AppConfig::query()
            ->where('key', 'filesystems.disks.oss.access_key')
            ->update([
                'name' => '阿里云OSS SecretKeySecret',
                'key' => 'filesystems.disks.oss.access_key_secret'
            ]);
    }

}
