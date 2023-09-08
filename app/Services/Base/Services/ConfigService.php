<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Base\Services;

use App\Exceptions\ServiceException;
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

    public function getPaidOrderSceneCredit1()
    {
        return config('meedu.member.credit1.paid_order');
    }

    /**
     * @return int
     */
    public function getRegisterSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.register');
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

    public function getIcpLink()
    {
        return config('meedu.system.icp_link');
    }

    public function getIcp2()
    {
        return config('meedu.system.icp2', '');
    }

    public function getIcp2Link()
    {
        return config('meedu.system.icp2_link', '');
    }

    /**
     * 播放器封面
     *
     * @return string
     */
    public function getPlayerCover(): string
    {
        return config('meedu.system.player_thumb') ?? '';
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
        return config('meedu.member.private_protocol') ?? '';
    }

    /**
     * 关于我们
     * @return string
     */
    public function getAboutus(): string
    {
        return config('meedu.aboutus') ?? '';
    }

    /**
     * 用户默认头像
     * @return string
     */
    public function getMemberDefaultAvatar(): string
    {
        return config('meedu.member.default_avatar') ?? '';
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
     * 短信配置
     * @return array
     */
    public function getSms(): array
    {
        return config('sms');
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
        $data = config('pay.wechat');

        // 回调地址
        $data['notify_url'] = route('payment.callback', ['wechat']);

        // 证书
        if (!$data['cert_client'] || !$data['cert_key']) {
            throw new ServiceException(__('微信证书未配置'));
        }

        // 微信证书生成
        $hash = md5($data['cert_client']);
        $certClientPath = storage_path('private/wechat_pay_cert_client_' . $hash . '.pem');
        if (!is_file($certClientPath)) {
            file_put_contents($certClientPath, $data['cert_client']);
        }
        $data['cert_client'] = $certClientPath;

        $hash = md5($data['cert_key']);
        $certKeyPath = storage_path('private/wechat_pay_cert_key_' . $hash . '.pem');
        if (!is_file($certKeyPath)) {
            file_put_contents($certKeyPath, $data['cert_key']);
        }
        $data['cert_key'] = $certKeyPath;

        return $data;
    }

    public function getAlipayPay(): array
    {
        $data = config('pay.alipay');
        if (!$data['app_cert_public_key'] || !$data['alipay_root_cert']) {
            throw new ServiceException(__('支付宝证书未配置'));
        }

        // 支付宝回调地址
        $data['notify_url'] = route('payment.callback', ['alipay']);

        // 证书
        $hash = md5($data['app_cert_public_key']);
        $appCertPublicKeyPath = storage_path('private/alipay_app_cert_public_key_' . $hash . '.crt');
        if (!is_file($appCertPublicKeyPath)) {
            file_put_contents($appCertPublicKeyPath, $data['app_cert_public_key']);
        }
        $data['app_cert_public_key'] = $appCertPublicKeyPath;

        $hash = md5($data['alipay_root_cert']);
        $rootCertPath = storage_path('private/alipay_root_cert_' . $hash . '.crt');
        if (!is_file($rootCertPath)) {
            file_put_contents($rootCertPath, $data['alipay_root_cert']);
        }
        $data['alipay_root_cert'] = $rootCertPath;

        return $data;
    }

    /**
     * 缓存状态
     *
     * @return boolean
     */
    public function getCacheStatus(): bool
    {
        return (int)config('meedu.system.cache.status') === 1;
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

    /**
     * 获取高德地图应用key
     *
     * @return string
     */
    public function getAmapkey(): string
    {
        return config('meedu.services.amap.key', '');
    }

    /**
     * 获取微信扫码登录成功回复语
     *
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getMpWechatScanLoginAlert()
    {
        return config('meedu.mp_wechat.scan_login_alert');
    }

    /**
     * @return int
     */
    public function getSocialiteQQLoginEnabled()
    {
        return (int)config('meedu.member.socialite.qq.enabled');
    }

    public function getSocialiteWechatScanLoginEnabled()
    {
        return (int)config('meedu.mp_wechat.enabled_scan_login');
    }

    public function getSocialiteWechatLoginEnabled()
    {
        return (int)config('meedu.mp_wechat.enabled_oauth_login');
    }

    public function getUrl(): string
    {
        return config('app.url');
    }

    // deprecated
    public function getTencentVodTranscodeFormat(): array
    {
        $format = strtolower(config('tencent.vod.transcode_format', ''));
        return $format ? explode(',', $format) : [];
    }

    /**
     * @return array
     */
    public function getTencentSms(): array
    {
        return config('sms.gateways.tencent');
    }

    /**
     * @return string
     */
    public function getPcUrl(): string
    {
        return config('meedu.system.pc_url');
    }

    /**
     * @return string
     */
    public function getH5Url(): string
    {
        return config('meedu.system.h5_url');
    }

    /**
     * @return bool
     */
    public function enabledFullSearch(): bool
    {
        return (bool)config('scout.meilisearch.host');
    }

    /**
     * @return string
     */
    public function getTencentVodPlayKey(): string
    {
        return config('meedu.system.player.tencent_play_key', '') ?? '';
    }

    /**
     * @return array
     */
    public function getPlayVideoFormatWhitelist(): array
    {
        $whitelist = config('meedu.system.player.video_format_whitelist') ?? '';
        if (!$whitelist) {
            return [];
        }
        return array_map('strtolower', explode(',', $whitelist));
    }

    /**
     * @return bool
     */
    public function enabledRedisCache(): bool
    {
        return config('cache.default') === 'redis';
    }
}
