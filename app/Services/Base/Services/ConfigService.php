<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Services\Base\Services;

use App\Constant\FrontendConstant;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class ConfigService implements ConfigServiceInterface
{

    /**
     * @return string
     */
    public function getMemberProtocol(): string
    {
        return config('meedu.member.protocol', '');
    }

    /**
     * @return string
     */
    public function getMemberDefaultAvatar(): string
    {
        return config('meedu.member.default_avatar');
    }

    /**
     * @return int
     */
    public function getMemberLockStatus(): int
    {
        return config('meedu.member.is_lock_default');
    }

    /**
     * @return int
     */
    public function getMemberActiveStatus(): int
    {
        return config('meedu.member.is_active_default');
    }

    /**
     * @return int
     */
    public function getCourseListPageSize(): int
    {
        return config('meedu.other.course_list_page_size', 6);
    }

    /**
     * @return array
     */
    public function getSeoCourseListPage(): array
    {
        return config('meedu.seo.course_list');
    }

    /**
     * @return int
     */
    public function getVideoListPageSize(): int
    {
        return config('meedu.other.video_list_page_size', 10);
    }

    /**
     * @return string
     */
    public function getEditor(): string
    {
        return config('meedu.system.editor', 'html');
    }

    /**
     * @return array
     */
    public function getSms(): array
    {
        return config('sms');
    }

    /**
     * @return array
     */
    public function getSeoRoleListPage(): array
    {
        return config('meedu.seo.role_list');
    }

    public function getSeoIndexPage(): array
    {
        return config('meedu.seo.index');
    }

    public function getPayments(): array
    {
        return config('meedu.payment');
    }

    public function getWechatPay(): array
    {
        return config('pay.wechat');
    }

    public function getAlipayPay(): array
    {
        return config('pay.alipay');
    }

    public function getCacheStatus(): bool
    {
        return (int)config('meedu.system.cache.status') === FrontendConstant::YES;
    }

    public function getCacheExpire(): int
    {
        return config('meedu.system.cache.expire');
    }

    public function getImageStorageDisk(): string
    {
        return config('meedu.upload.image.disk');
    }

    public function getImageStoragePath(): string
    {
        return config('meedu.upload.image.path');
    }

    public function getRegisterSmsTemplateId(): string
    {
        return $this->getTemplateId('register');
    }

    public function getLoginSmsTemplateId(): string
    {
        return $this->getTemplateId('login');
    }

    public function getPasswordResetSmsTemplateId(): string
    {
        return $this->getTemplateId('password_reset');
    }

    public function getMobileBindSmsTemplateId(): string
    {
        return $this->getTemplateId('mobile_bind');
    }

    protected function getTemplateId($scene): string
    {
        $supplier = config('meedu.system.sms');
        $gateways = config('sms.gateways');
        $supplierConfig = $gateways[$supplier] ?? [];
        return $supplierConfig['template'][$scene] ?? '';
    }

    public function getHandPayIntroducation(): string
    {
        return config('meedu.payment.handPay.introduction') ?? '';
    }

    public function getEnabledSocialiteApps(): array
    {
        $apps = config('meedu.member.socialite');
        $list = [];
        foreach ($apps as $app) {
            if (!($app['enabled'] ?? false)) {
                continue;
            }
            $list[] = $app;
        }
        return $list;
    }

    public function getMeEduConfig(): array
    {
        return config('meedu');
    }

    public function getMemberInviteConfig(): array
    {
        return config('meedu.member.invite');
    }

    /**
     * @return array
     */
    public function getTencentVodConfig(): array
    {
        return config('tencent.vod');
    }

    /**
     * @return array
     */
    public function getTencentWechatMiniConfig(): array
    {
        return config('tencent.wechat.mini');
    }
}
