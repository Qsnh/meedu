<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Core\UpgradeLog;

use App\Constant\FrontendConstant;
use App\Services\Base\Model\AppConfig;

class UpgradeToV46
{
    public static function handle()
    {
        self::configMigrate();
        self::updateLoginLimitConfig();

        self::deleteSomeConfig();
    }

    public static function configMigrate()
    {
        // 将原先的腾讯云播放格式白名单迁移到新的统一的播放视频白名单格式
        $value = AppConfig::query()
                ->where('key', 'tencent.vod.transcode_format')
                ->value('value') ?? '';
        AppConfig::query()
            ->where('key', 'meedu.system.player.video_format_whitelist')
            ->update(['value' => $value]);
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

    public static function updateLoginLimitConfig()
    {
        // 移除原先的[允许每个平台一台设备登录:2]的选项
        AppConfig::query()
            ->where('key', 'meedu.system.login.limit.rule')
            ->update([
                'help' => '',
                'option_value' => json_encode([
                    [
                        'title' => '不限制',
                        'key' => \App\Constant\FrontendConstant::LOGIN_LIMIT_RULE_DEFAULT,
                    ],
                    [
                        'title' => '仅允许一台设备在线',
                        'key' => \App\Constant\FrontendConstant::LOGIN_LIMIT_RULE_ALL,
                    ],
                ]),
            ]);

        // 修改选项之后，如果当前配置选择了已经被移除的选项值[2]的话那么将该值改为[3]
        $value = (int)AppConfig::query()
            ->where('key', 'meedu.system.login.limit.rule')
            ->value('value');
        if ($value === 2) {
            AppConfig::query()
                ->where('key', 'meedu.system.login.limit.rule')
                ->update(['value' => FrontendConstant::LOGIN_LIMIT_RULE_ALL]);
        }
    }
}
