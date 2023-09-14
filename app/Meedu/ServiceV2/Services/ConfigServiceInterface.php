<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

interface ConfigServiceInterface
{
    public function getSuperAdministratorSlug(): string;

    public function getEnabledSocialiteApps(): array;

    public function getLoginLimitRule(): int;

    public function isCloseDeprecatedApi(): bool;

    public function getMpWechatScanLoginAlert(): string;

    public function getTencentFaceConfig(): array;

    public function enabledFaceVerify(): bool;

    public function getVideoDefaultService(): string;

    public function getApiUrl(): string;

    public function getPCUrl(): string;

    public function getH5Url(): string;

    public function getLogo(): string;

    public function allKeyValue(): array;
}
