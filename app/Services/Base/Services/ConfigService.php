<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Services\Base\Services;

use Illuminate\Support\Str;
use App\Exceptions\ServiceException;
use App\Services\Base\Model\AppConfig;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class ConfigService implements ConfigServiceInterface
{
    public function getWatchedVideoSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.watched_video');
    }

    public function getWatchedCourseSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.watched_course');
    }

    public function getPaidOrderSceneCredit1()
    {
        return config('meedu.member.credit1.paid_order');
    }

    public function getRegisterSceneCredit1(): int
    {
        return (int)config('meedu.member.credit1.register');
    }

    public function getName(): string
    {
        return config('app.name') ?? '';
    }

    public function getIcp(): string
    {
        return config('meedu.system.icp') ?? '';
    }

    public function getIcpLink(): string
    {
        return config('meedu.system.icp_link') ?? '';
    }

    public function getIcp2(): string
    {
        return config('meedu.system.icp2') ?? '';
    }

    public function getIcp2Link(): string
    {
        return config('meedu.system.icp2_link') ?? '';
    }

    public function getPlayerCover(): string
    {
        return config('meedu.system.player_thumb') ?? '';
    }

    public function getPlayer(): array
    {
        return config('meedu.system.player');
    }

    public function getLogo(): array
    {
        return [
            'logo' => config('meedu.system.logo'),
            'white_logo' => config('meedu.system.white_logo'),
        ];
    }

    public function getMemberProtocol(): string
    {
        return config('meedu.member.protocol') ?? '';
    }

    public function getMemberPrivateProtocol(): string
    {
        return config('meedu.member.private_protocol') ?? '';
    }

    public function getAboutus(): string
    {
        return config('meedu.aboutus') ?? '';
    }

    public function getMemberDefaultAvatar(): string
    {
        return config('meedu.member.default_avatar') ?? '';
    }

    public function getMemberLockStatus(): int
    {
        return (int)config('meedu.member.is_lock_default');
    }

    public function getMemberActiveStatus(): int
    {
        return (int)config('meedu.member.is_active_default');
    }

    public function getSms(): array
    {
        return config('sms');
    }

    public function getPayments(): array
    {
        return config('meedu.payment');
    }

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

        // 支付宝公钥证书
        if (Str::startsWith($data['ali_public_key'], '-----BEGIN')) {
            $hash = md5($data['ali_public_key']);
            $aliPublicKeyPath = storage_path('private/ali_public_key_' . $hash . '.crt');
            if (!is_file($aliPublicKeyPath)) {
                file_put_contents($aliPublicKeyPath, $data['ali_public_key']);
            }
            $data['ali_public_key'] = $aliPublicKeyPath;
        }

        // 支付宝应用公钥证书
        $hash = md5($data['app_cert_public_key']);
        $appCertPublicKeyPath = storage_path('private/alipay_app_cert_public_key_' . $hash . '.crt');
        if (!is_file($appCertPublicKeyPath)) {
            file_put_contents($appCertPublicKeyPath, $data['app_cert_public_key']);
        }
        $data['app_cert_public_key'] = $appCertPublicKeyPath;

        // 支付宝根证书
        $hash = md5($data['alipay_root_cert']);
        $rootCertPath = storage_path('private/alipay_root_cert_' . $hash . '.crt');
        if (!is_file($rootCertPath)) {
            file_put_contents($rootCertPath, $data['alipay_root_cert']);
        }
        $data['alipay_root_cert'] = $rootCertPath;

        return $data;
    }

    public function getCacheStatus(): bool
    {
        return (int)config('meedu.system.cache.status') === 1;
    }

    public function getCacheExpire(): int
    {
        return (int)config('meedu.system.cache.expire');
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
            if ((int)($app['enabled'] ?? 0) !== 1) {
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

    public function getEnabledMobileBindAlert(): int
    {
        return (int)config('meedu.member.enabled_mobile_bind_alert', 0);
    }

    public function getMemberInviteConfig(): array
    {
        return config('meedu.member.invite');
    }

    public function getTencentVodConfig(): array
    {
        return config('tencent.vod');
    }

    public function getAliyunPrivatePlayStatus(): bool
    {
        return (int)config('meedu.system.player.enabled_aliyun_private') === 1;
    }

    public function all(): array
    {
        return AppConfig::query()->orderBy('sort')->get()->toArray();
    }

    public function isConfigExists(string $key): bool
    {
        return AppConfig::query()->where('key', $key)->exists();
    }

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

    public function getAliyunVodConfig(): array
    {
        return config('meedu.upload.video.aliyun');
    }

    public function getLoginLimitRule(): int
    {
        return (int)config('meedu.system.login.limit.rule');
    }

    public function getMpWechatConfig(): array
    {
        $config = config('meedu.mp_wechat');
        return $config ? $config : [];
    }

    public function getMemberRegisterSendVipConfig(): array
    {
        return config('meedu.member.register.vip') ?? [];
    }

    public function getMpWechatScanLoginAlert(): string
    {
        return config('meedu.mp_wechat.scan_login_alert') ?? '';
    }

    public function getSocialiteQQLoginEnabled(): int
    {
        return (int)config('meedu.member.socialite.qq.enabled');
    }

    public function getSocialiteWechatScanLoginEnabled(): int
    {
        return (int)config('meedu.mp_wechat.enabled_scan_login');
    }

    public function getSocialiteWechatLoginEnabled(): int
    {
        return (int)config('meedu.mp_wechat.enabled_oauth_login');
    }

    public function getUrl(): string
    {
        return config('app.url') ?? '';
    }

    public function getTencentSms(): array
    {
        return config('sms.gateways.tencent');
    }

    public function getPcUrl(): string
    {
        return config('meedu.system.pc_url') ?? '';
    }

    public function getH5Url(): string
    {
        return config('meedu.system.h5_url') ?? '';
    }

    public function enabledFullSearch(): bool
    {
        return (bool)config('scout.meilisearch.host');
    }

    public function getTencentVodPlayKey(): string
    {
        return config('meedu.system.player.tencent_play_key') ?? '';
    }

    public function getPlayVideoFormatWhitelist(): array
    {
        $whitelist = config('meedu.system.player.video_format_whitelist') ?? '';
        if (!$whitelist) {
            return [];
        }
        return array_map('strtolower', explode(',', $whitelist));
    }

    public function enabledRedisCache(): bool
    {
        return 'redis' === config('cache.default');
    }
}
