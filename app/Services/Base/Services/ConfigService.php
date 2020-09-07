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
use App\Services\Base\Model\AppConfig;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class ConfigService implements ConfigServiceInterface
{

    /**
     * @return int
     */
    public function getWatchedVideoSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.watched_video');
    }

    /**
     * @return int
     */
    public function getWatchedCourseSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.watched_course');
    }

    /**
     * @return int
     */
    public function getPaidOrderSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.paid_order');
    }

    /**
     * @return int
     */
    public function getRegisterSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.register');
    }

    /**
     * @return int
     */
    public function getInviteSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.invite');
    }

    /**
     * 获取服务配置
     *
     * @param string $app
     * @return array
     */
    public function getServiceConfig(string $app): array
    {
        return config('services.' . $app, []);
    }

    /**
     * 网站名
     *
     * @return string
     */
    public function getName(): string
    {
        return config('app.name');
    }

    /**
     * ICP
     *
     * @return string
     */
    public function getIcp(): string
    {
        return config('meedu.system.icp', '');
    }

    /**
     * 播放器封面
     *
     * @return string
     */
    public function getPlayerCover(): string
    {
        return config('meedu.system.player_thumb', '');
    }

    /**
     * 播放器配置
     *
     * @return array
     */
    public function getPlayer(): array
    {
        return config('meedu.system.player');
    }

    /**
     * 获取logo
     *
     * @return array
     */
    public function getLogo(): array
    {
        return [
            'logo' => config('meedu.system.logo'),
            'white_logo' => config('meedu.system.white_logo'),
        ];
    }

    /**
     * 获取用户协议
     * @return string
     */
    public function getMemberProtocol(): string
    {
        return config('meedu.member.protocol', '');
    }

    /**
     * 获取用户隐私协议
     * @return string
     */
    public function getMemberPrivateProtocol(): string
    {
        return config('meedu.member.private_protocol', '');
    }

    /**
     * 关于我们
     * @return string
     */
    public function getAboutus(): string
    {
        return config('meedu.aboutus', '');
    }

    /**
     * 用户默认头像
     * @return string
     */
    public function getMemberDefaultAvatar(): string
    {
        return config('meedu.member.default_avatar');
    }

    /**
     * 用户默认锁定状态
     * @return int
     */
    public function getMemberLockStatus(): int
    {
        return (int)config('meedu.member.is_lock_default');
    }

    /**
     * 用户默认激活状态
     * @return int
     */
    public function getMemberActiveStatus(): int
    {
        return (int)config('meedu.member.is_active_default');
    }

    /**
     * 课程列表默认显示条数
     * @return int
     */
    public function getCourseListPageSize(): int
    {
        return (int)config('meedu.other.course_list_page_size', 6);
    }

    /**
     * 课程列表页面SEO
     * @return array
     */
    public function getSeoCourseListPage(): array
    {
        return config('meedu.seo.course_list');
    }

    /**
     * 视频列表页面显示条数
     * @return int
     */
    public function getVideoListPageSize(): int
    {
        return (int)config('meedu.other.video_list_page_size', 10);
    }

    /**
     * 获取默认的编辑器
     * @return string
     */
    public function getEditor(): string
    {
        return config('meedu.system.editor', 'html');
    }

    /**
     * 短信配置
     * @return array
     */
    public function getSms(): array
    {
        return config('sms');
    }

    /**
     * 会员界面SEO
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

    /**
     * 支付网关
     *
     * @return array
     */
    public function getPayments(): array
    {
        return config('meedu.payment');
    }

    /**
     * 微信支付配置
     *
     * @return array
     */
    public function getWechatPay(): array
    {
        return config('pay.wechat');
    }

    /**
     * 支付宝支付配置
     *
     * @return array
     */
    public function getAlipayPay(): array
    {
        return config('pay.alipay');
    }

    /**
     * 缓存状态
     *
     * @return boolean
     */
    public function getCacheStatus(): bool
    {
        return (int)config('meedu.system.cache.status') === FrontendConstant::YES;
    }

    /**
     * 缓存时间
     *
     * @return integer
     */
    public function getCacheExpire(): int
    {
        return (int)config('meedu.system.cache.expire');
    }

    /**
     * 图片存储驱动
     *
     * @return string
     */
    public function getImageStorageDisk(): string
    {
        return config('meedu.upload.image.disk');
    }

    /**
     * 图片存储路径
     *
     * @return string
     */
    public function getImageStoragePath(): string
    {
        return config('meedu.upload.image.path');
    }

    /**
     * 注册短信模板ID
     *
     * @return string
     */
    public function getRegisterSmsTemplateId(): string
    {
        return $this->getTemplateId('register');
    }

    /**
     * 登录短信模板ID
     *
     * @return string
     */
    public function getLoginSmsTemplateId(): string
    {
        return $this->getTemplateId('login');
    }

    /**
     * 密码重置模板ID
     *
     * @return string
     */
    public function getPasswordResetSmsTemplateId(): string
    {
        return $this->getTemplateId('password_reset');
    }

    /**
     * 手机号绑定模板ID
     *
     * @return string
     */
    public function getMobileBindSmsTemplateId(): string
    {
        return $this->getTemplateId('mobile_bind');
    }

    /**
     * 获取某个场景的短信模板id
     *
     * @param [type] $scene
     * @return string
     */
    protected function getTemplateId($scene): string
    {
        $supplier = config('meedu.system.sms');
        $gateways = config('sms.gateways');
        $supplierConfig = $gateways[$supplier] ?? [];
        return $supplierConfig['template'][$scene] ?? '';
    }

    /**
     * 手动支付详情
     *
     * @return string
     */
    public function getHandPayIntroducation(): string
    {
        return config('meedu.payment.handPay.introduction') ?? '';
    }

    /**
     * 已开启的社交登录app
     *
     * @return array
     */
    public function getEnabledSocialiteApps(): array
    {
        $apps = config('meedu.member.socialite');
        $list = [];
        foreach ($apps as $app) {
            if ((int)($app['enabled'] ?? 0) !== 1) {
                continue;
            }
            $list[] = $app;
        }
        return $list;
    }

    /**
     * meedu系统配置
     *
     * @return array
     */
    public function getMeEduConfig(): array
    {
        return config('meedu');
    }

    /**
     * 获取手机号强制绑定状态开关
     *
     * @return integer
     */
    public function getEnabledMobileBindAlert(): int
    {
        return (int)config('meedu.member.enabled_mobile_bind_alert', 0);
    }

    /**
     * 会员邀请配置
     *
     * @return array
     */
    public function getMemberInviteConfig(): array
    {
        return config('meedu.member.invite');
    }

    /**
     * 腾讯云VOD配置
     *
     * @return array
     */
    public function getTencentVodConfig(): array
    {
        return config('tencent.vod');
    }

    /**
     * 腾讯小程序配置
     *
     * @return array
     */
    public function getTencentWechatMiniConfig(): array
    {
        return config('tencent.wechat.mini');
    }

    /**
     * 阿里云私密播放状态
     *
     * @return bool
     */
    public function getAliyunPrivatePlayStatus(): bool
    {
        return (int)config('meedu.system.player.enabled_aliyun_private') === 1;
    }

    /**
     * 获取所有配置
     * @return array
     */
    public function all(): array
    {
        return AppConfig::query()->orderBy('sort')->get()->toArray();
    }

    /**
     * 检测配置是否存在
     * @param string $key
     * @return bool
     */
    public function isConfigExists(string $key): bool
    {
        return AppConfig::query()->where('key', $key)->exists();
    }

    /**
     * 写入配置
     * @param array $config
     */
    public function setConfig(array $config): void
    {
        $data = array_column($this->all(), 'key');
        foreach ($config as $key => $value) {
            if (!in_array($key, $data)) {
                continue;
            }
            AppConfig::query()->where('key', $key)->update(['value' => $value]);
        }
    }

    /**
     * 获取阿里云VOD配置
     * @return array
     */
    public function getAliyunVodConfig(): array
    {
        return config('meedu.upload.video.aliyun');
    }

    /**
     * 登录限制规则
     *
     * @return int
     */
    public function getLoginLimitRule(): int
    {
        return (int)config('meedu.system.login.limit.rule');
    }

    /**
     * 微信公众号配置
     * @return array
     */
    public function getMpWechatConfig(): array
    {
        $config = config('meedu.mp_wechat');
        return $config ? $config : [];
    }

    /**
     * 获取注册送VIP的配置
     * @return array
     */
    public function getMemberRegisterSendVipConfig(): array
    {
        return config('meedu.member.register.vip') ?? [];
    }
}
