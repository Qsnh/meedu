<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\ServiceV2\Services;

use Illuminate\Support\Str;
use App\Constant\ConfigConstant;
use App\Exceptions\ServiceException;
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

    public function getAliVodCallbackKey(): string
    {
        return config('meedu.upload.video.aliyun.callback_key') ?? '';
    }

    public function updateAliyunVodCallbackKey(string $callbackKey): void
    {
        $this->dao->updateValueByKey(ConfigConstant::ALIYUN_VOD_CALLBACK_KEY, $callbackKey);
    }

    public function getAliyunVodConfig(): array
    {
        return config('meedu.upload.video.aliyun') ?? [];
    }

    public function getChunksConfigValues(array $array): array
    {
        return $this->dao->getChunksByKeys($array);
    }

    public function getTencentVodConfig(): array
    {
        return config('tencent.vod');
    }

    public function updateTencentVodCallbackKey(string $callbackKey): void
    {
        $this->dao->updateValueByKey(ConfigConstant::TENCENT_VOD_CALLBACK_KEY, $callbackKey);
    }

    public function getTencentVodCallbackKey(): string
    {
        return config('tencent.vod.callback_key') ?? '';
    }

    public function updateAliyunVodPlayKey(string $playKey): void
    {
        $this->dao->updateValueByKey(ConfigConstant::ALIYUN_VOD_PLAY_KEY, $playKey);
    }

    public function updateTencentVodPlayKey(string $playKey): void
    {
        $this->dao->updateValueByKey(ConfigConstant::TENCENT_VOD_PLAY_KEY, $playKey);
    }

    public function appName(): string
    {
        return config('meedu.system.name') ?? '';
    }

    public function all(): array
    {
        return $this->dao->all();
    }

    public function getS3PublicConfig(): array
    {
        return config('s3.public');
    }

    public function getS3PrivateConfig(): array
    {
        return config('s3.private');
    }

    public function enabledWechatPayment(): bool
    {
        return (int)config('meedu.payment.alipay.enabled') === 1;
    }

    public function enabledAlipayPayment(): bool
    {
        return (int)config('meedu.payment.wechat.enabled') === 1;
    }

    public function enabledHandPayPayment(): bool
    {
        return (int)config('meedu.payment.handPay.enabled') === 1;
    }

    public function handPayInfo(): string
    {
        return config('meedu.payment.handPay.introduction') ?? '';
    }

    public function getWechatPayConfig(): array
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

    public function getAlipayConfig(): array
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

    public function getMemberDefaultAvatar(): string
    {
        return url(config('meedu.member.default_avatar'));
    }


}
