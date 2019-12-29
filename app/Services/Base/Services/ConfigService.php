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
     * @return string
     */
    public function getDefaultStorageDisk(): string
    {
        return config('filesystems.default');
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
        return config('meedu.system.cache.status') == FrontendConstant::YES;
    }

    public function getCacheExpire(): int
    {
        return config('meedu.system.cache.expire');
    }

    public function getSmsLimiter(): array
    {
        return config('meedu.system.limiter.sms');
    }

    public function getImageStorageDisk(): string
    {
        return config('meedu.upload.image.disk');
    }

    public function getImageStoragePath(): string
    {
        return config('meedu.upload.image.path');
    }
}
