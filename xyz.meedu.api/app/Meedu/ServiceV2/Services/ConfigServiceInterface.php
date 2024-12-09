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

    public function getTencentFaceConfig(): array;

    public function enabledFaceVerify(): bool;

    public function getVideoDefaultService(): string;

    public function getApiUrl(): string;

    public function getPCUrl(): string;

    public function getH5Url(): string;

    public function getLogo(): string;

    public function allKeyValue(): array;

    public function getVipProtocol(): string;

    public function getAliVodCallbackKey(): string;

    public function updateAliyunVodCallbackKey(string $callbackKey): void;

    public function getAliyunVodConfig(): array;

    public function getChunksConfigValues(array $array): array;

    public function getTencentVodConfig(): array;

    public function updateTencentVodCallbackKey(string $callbackKey): void;

    public function getTencentVodCallbackKey(): string;

    public function updateAliyunVodPlayKey(string $playKey): void;

    public function updateTencentVodPlayKey(string $playKey): void;

    public function appName(): string;

    public function all(): array;

    public function getS3PublicConfig(): array;

    public function getS3PrivateConfig(): array;
}
