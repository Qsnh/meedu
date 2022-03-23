<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\UpgradeLog;

use App\Services\Base\Model\AppConfig;

class UpgradeToV46
{
    public static function handle()
    {
        self::configMigrate();
        
        self::deleteSomeConfig();
    }

    public static function configMigrate()
    {
        $value = AppConfig::query()->where('key', 'tencent.vod.transcode_format')->value('value') ?? '';
        AppConfig::query()->where('key', 'meedu.system.player.video_format_whitelist')->update(['value' => $value]);
    }

    public static function deleteSomeConfig()
    {
        AppConfig::query()
            ->whereIn('key', [
                // 腾讯云播放视频格式白名单[已引入统一的白名单]
                'tencent.vod.transcode_format',
            ])
            ->delete();
    }
}
