<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use App\Meedu\Hooks\HookRun;
use App\Meedu\Hooks\HookParams;
use App\Meedu\Sms\SmsInterface;
use App\Constant\ConfigConstant;
use Illuminate\Support\Facades\Log;
use App\Meedu\Hooks\Constant\PositionConstant;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class Setting
{
    const VERSION = 1;

    protected $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    public function put(array $config): void
    {
        $config = $this->removeUnChangeItems($config);
        $this->configService->setConfig($config);
    }

    private function removeUnChangeItems(array $config): array
    {
        foreach ($config as $key => $val) {
            if (ConfigConstant::PRIVATE_MASK === $val) {
                unset($config[$key]);
            }
        }
        return $config;
    }

    public function append($config): void
    {
        $this->put($config);
    }

    public function sync(): void
    {
        $config = $this->allConfigTransformedKeyValue();

        // 优先读取 app_config 表的配置，其次读取 env 和 默认配置值
        foreach ($this->syncWhitelistKeys() as $tmpKey) {
            if (!isset($config[$tmpKey])) {
                continue;
            }
            $localConfigValue = config($tmpKey);//本地变量值=>代码写死的|env读取的
            $appConfigValue = $config[$tmpKey];//写入到AppConfig表的
            // 如果AppConfig没值但是本地变量有值的话
            // 则使用本地变量的值
            if (trim($appConfigValue) === '' && $localConfigValue !== '') {
                $config[$tmpKey] = $localConfigValue;
            }
        }

        config($config);
        // s3配置重写
        $this->s3ConfigOverride($config);
        // 短信服务注册
        $this->smsServiceProviderRegister();
    }

    private function allConfigTransformedKeyValue(): array
    {
        try {
            $config = $this->configService->all();
            $data = [];
            foreach ($config as $item) {
                $data[$item['key']] = $item['value'];
            }
            return $data;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . '|读取AppConfig失败|错误信息:' . $e->getMessage());
            return [];
        }
    }

    private function smsServiceProviderRegister(): void
    {
        $smsService = ucfirst(config('meedu.system.sms'));
        app()->instance(SmsInterface::class, app()->make('App\\Meedu\\Sms\\' . $smsService));
    }

    private function s3ConfigOverride(array $config): void
    {
        foreach (ConfigConstant::S3_CONFIG_OVERRIDE as $frameworkKey => $diyKey) {
            if (isset($config[$diyKey])) {
                config([$frameworkKey => $config[$diyKey]]);
            }
        }

        config(['filesystems.disks.s3-public.use_path_style_endpoint' => config('s3.public.use_path_style_endpoint')]);
        config(['filesystems.disks.s3-private.use_path_style_endpoint' => config('s3.private.use_path_style_endpoint')]);
    }

    public function syncWhitelistKeys(): array
    {
        $syncWhitelistKeys = [
            'meedu.system.pc_url',
            'meedu.system.h5_url',
            'scout.meilisearch.host',
            'scout.meilisearch.key',
        ];
        return HookRun::run(PositionConstant::SYSTEM_APP_CONFIG_SYNC_WHITELIST, new HookParams($syncWhitelistKeys));
    }
}
