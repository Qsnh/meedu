<?php

namespace App\Meedu\Core\UpgradeLog;

use App\Meedu\ServiceV2\Models\AppConfig;

class UpgradeToV4911
{

    public static function handle()
    {
        self::upgradeImageDiskConfigItem();
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

}