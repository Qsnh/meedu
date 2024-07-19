<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Constant\ConfigConstant;
use App\Models\AdministratorPermission;
use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeToV4911
{

    public static function handle()
    {
        self::upgradeImageDiskConfigItem();
        self::deleteSomeConfigItems();
        self::deleteSomePermissions();
        self::hideAliyunVodHostConfigItem();
    }

    public static function deleteSomePermissions()
    {
        AdministratorPermission::query()
            ->whereIn('slug', [
                'media.video.store',
            ])
            ->delete();
    }

    public static function deleteSomeConfigItems()
    {
        AppConfig::query()
            ->whereIn('key', [
                'filesystems.disks.qiniu.domains.default',
                'filesystems.disks.qiniu.domains.https',
                'filesystems.disks.qiniu.access_key',
                'filesystems.disks.qiniu.secret_key',
                'filesystems.disks.qiniu.bucket',

                'app.name',
                'app.debug',

                'meedu.system.player.video_format_whitelist',
            ])
            ->delete();
    }

    public static function upgradeImageDiskConfigItem()
    {
        AppConfig::query()
            ->where('key', 'meedu.upload.image.disk')
            ->update([
                'option_value' => json_encode([
                    [
                        'title' => '本地',
                        'key' => 'public',
                    ],
                    [
                        'title' => '阿里云OSS',
                        'key' => 'oss',
                    ],
                    [
                        'title' => '腾讯云COS',
                        'key' => 'cos',
                    ],
                ], JSON_UNESCAPED_UNICODE),
            ]);
    }

    public static function hideAliyunVodHostConfigItem()
    {
        AppConfig::query()
            ->where('key', ConfigConstant::ALIYUN_VOD_HOST)
            ->update(['is_show' => 0]);
    }
}
