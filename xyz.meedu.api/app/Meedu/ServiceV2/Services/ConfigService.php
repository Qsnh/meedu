<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use App\Meedu\ServiceV2\Dao\OtherDaoInterface;

class ConfigService implements ConfigServiceInterface
{

    private $dao;

    public function __construct(OtherDaoInterface $dao)
    {
        $this->dao = $dao;
    }

    public function allKeyValue(): array
    {
        return $this->dao->appConfigValueKey();
    }

    public function getSuperAdministratorSlug(): string
    {
        return config('meedu.administrator.super_slug') ?? '';
    }

    public function getEnabledSocialiteApps(): array
    {
        return collect(config('meedu.member.socialite', []))->filter(function ($item) {
            return (int)($item['enabled'] ?? 0) == 1;
        })->toArray();
    }

    public function getLoginLimitRule(): int
    {
        return (int)config('meedu.system.login.limit.rule', 0);
    }

    public function isCloseDeprecatedApi(): bool
    {
        return (bool)config('meedu.system.close_deprecated_api');
    }

    public function getMpWechatScanLoginAlert(): string
    {
        return config('meedu.mp_wechat.scan_login_alert') ?? '';
    }

    public function getTencentFaceConfig(): array
    {
        return config('tencent.face') ?? [];
    }

    public function enabledFaceVerify(): bool
    {
        return (int)config('meedu.member.enabled_face_verify') === 1;
    }

    public function getVideoDefaultService(): string
    {
        return config('meedu.upload.video.default_service') ?? '';
    }

    public function getApiUrl(): string
    {
        return rtrim(config('app.url') ?? '');
    }

    public function getPCUrl(): string
    {
        return rtrim(config('meedu.system.pc_url') ?? '');
    }

    public function getH5Url(): string
    {
        return rtrim(config('meedu.system.h5_url') ?? '');
    }

    public function getLogo(): string
    {
        $url = config('meedu.system.logo') ?? '';
        if ($url) {
            $url = url($url);
        }
        return $url;
    }

    public function getVipProtocol(): string
    {
        return config('meedu.member.vip_protocol') ?? '';
    }
}
