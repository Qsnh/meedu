<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Base\Interfaces;

interface ConfigServiceInterface
{
    public function getWatchedVideoSceneCredit1(): int;

    public function getWatchedCourseSceneCredit1(): int;

    public function getPaidOrderSceneCredit1();

    public function getRegisterSceneCredit1(): int;

    public function getName(): string;

    public function getIcp(): string;

    public function getIcpLink(): string;

    public function getIcp2(): string;

    public function getIcp2Link(): string;

    public function getPlayerCover(): string;

    public function getPlayer(): array;

    public function getLogo(): array;

    public function getMemberProtocol(): string;

    public function getMemberPrivateProtocol(): string;

    public function getAboutus(): string;

    public function getMemberDefaultAvatar(): string;

    public function getMemberLockStatus(): int;

    public function getMemberActiveStatus(): int;

    public function getSms(): array;

    public function getPayments(): array;

    public function getWechatPay(): array;

    public function getAlipayPay(): array;

    public function getCacheStatus(): bool;

    public function getCacheExpire(): int;

    public function getImageStorageDisk(): string;

    public function getImageStoragePath(): string;

    public function getRegisterSmsTemplateId(): string;

    public function getLoginSmsTemplateId(): string;

    public function getPasswordResetSmsTemplateId(): string;

    public function getMobileBindSmsTemplateId(): string;

    public function getHandPayIntroducation(): string;

    public function getEnabledSocialiteApps(): array;

    public function getMeEduConfig(): array;

    public function getEnabledMobileBindAlert(): int;

    public function getMemberInviteConfig(): array;

    public function getTencentVodConfig(): array;

    public function getAliyunPrivatePlayStatus(): bool;

    public function all(): array;

    public function isConfigExists(string $key): bool;

    public function setConfig(array $config): void;

    public function getAliyunVodConfig(): array;

    public function getLoginLimitRule(): int;

    public function getMpWechatConfig(): array;

    public function getMemberRegisterSendVipConfig(): array;

    public function getMpWechatScanLoginAlert(): string;

    public function getSocialiteQQLoginEnabled(): int;

    public function getSocialiteWechatScanLoginEnabled(): int;

    public function getSocialiteWechatLoginEnabled(): int;

    public function getUrl(): string;

    public function getTencentSms(): array;

    public function getPcUrl(): string;

    public function getH5Url(): string;

    public function enabledFullSearch(): bool;

    public function getTencentVodPlayKey(): string;

    public function getPlayVideoFormatWhitelist(): array;

    public function enabledRedisCache(): bool;

}
