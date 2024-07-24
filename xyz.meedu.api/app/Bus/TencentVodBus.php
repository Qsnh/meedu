<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Bus;

use App\Meedu\Tencent\Vod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceException;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class TencentVodBus
{

    private $appId;
    private $secretId;
    private $secretKey;
    private $callbackKey;
    private $playDomain;
    private $playKey;

    private $vodLib;

    public function __construct(array $config)
    {
        $this->appId = $config['app_id'];
        $this->secretId = $config['secret_id'];
        $this->secretKey = $config['secret_key'];

        isset($config['callback_key']) && $this->callbackKey = $config['callback_key'];
        isset($config['play_domain']) && $this->playDomain = $config['play_domain'];
        isset($config['play_key']) && $this->playKey = $config['play_key'];
    }

    public function getConfig(): array
    {
        return [
            'app_id' => $this->appId,
            'secret_id' => $this->secretId,
            'secret_key' => $this->secretKey,
            'callback_key' => $this->callbackKey,
            'play_domain' => $this->playDomain,
            'play_key' => $this->playKey,
        ];
    }

    /**
     * @return Vod
     */
    public function getVodLib()
    {
        if (!$this->vodLib) {
            $this->vodLib = new Vod($this->getConfig());
        }
        return $this->vodLib;
    }

    public function callbackSync(bool $throw = false): void
    {
        if (
            !$this->appId ||
            !$this->secretId ||
            !$this->secretKey
        ) {
            return;
        }

        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        if (!$this->callbackKey) {
            $this->callbackKey = base64_decode('TWVFZHUyMDIw=') . Str::random(20);
            $configService->updateTencentVodCallbackKey($this->callbackKey);
        }

        $callbackUrl = trim($configService->getApiUrl(), '/') . route('tencent.vod.callback', ['sign' => $this->callbackKey], false);

        $vod = $this->getVodLib();

        try {
            $callbackConfig = $vod->describeEventConfig();

            Log::info(__METHOD__ . '|腾讯云callback查询结果', $callbackConfig ? [
                'mode' => $callbackConfig['mode'],
                'is_enabled_upload_media_complete' => $callbackConfig['is_enabled_upload_media_complete'],
                'is_enabled_delete_media_complete' => $callbackConfig['is_enabled_delete_media_complete'],
                'notification_url' => mb_substr($callbackConfig['notification_url'], 0, mb_strlen($callbackConfig['notification_url']) - 15).'***'.mb_substr($callbackConfig['notification_url'], -8, 8),
            ] : $callbackConfig);

            if (
                !$callbackConfig ||
                'PUSH' !== $callbackConfig['mode'] ||
                !$callbackConfig['is_enabled_upload_media_complete'] ||
                !$callbackConfig['is_enabled_delete_media_complete'] ||
                $callbackConfig['notification_url'] !== $callbackUrl
            ) {
                $vod->modifyEventConfig($callbackUrl);
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|腾讯云callback设置失败.错误信息:' . $e->getMessage());
            if ($throw) {
                throw new ServiceException($e->getMessage());
            }
        }
    }

    public function playKeySync(): void
    {
        if (
            !$this->appId ||
            !$this->secretId ||
            !$this->secretKey ||
            !$this->playDomain
        ) {
            return;
        }

        /**
         * @var ConfigServiceInterface $configService
         */
        $configService = app()->make(ConfigServiceInterface::class);

        if (!$this->playKey) {
            $this->playKey = base64_decode('bWVlZFUyMDIz') . Str::random(20);
            $configService->updateTencentVodPlayKey($this->playKey);
        }

        $vod = $this->getVodLib();

        try {
            $domainInfo = $vod->describeVodDomains($this->playDomain);

            Log::info(__METHOD__ . '|腾讯云playKey查询结果', $domainInfo ? [
                'UrlSignatureAuthPolicy.Status' => $domainInfo['UrlSignatureAuthPolicy']['Status'],
                'UrlSignatureAuthPolicy.EncryptedKey' => mb_substr($domainInfo['UrlSignatureAuthPolicy']['EncryptedKey'], 0, 10) . '***' . mb_substr($domainInfo['UrlSignatureAuthPolicy']['EncryptedKey'], -10, 10),
            ] : $domainInfo);

            if (
                !$domainInfo ||
                'Enabled' !== $domainInfo['UrlSignatureAuthPolicy']['Status'] ||
                $this->playKey !== $domainInfo['UrlSignatureAuthPolicy']['EncryptedKey']
            ) {
                $vod->modifyVodDomainConfig($this->playDomain, $this->playKey);
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|腾讯云的playKey设置失败.错误信息:' . $e->getMessage());
        }
    }

}
