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
        $config = $this->removeUnChange($config);
        $this->configService->setConfig($config);
    }

    public function append($config): void
    {
        $this->put($config);
    }

    public function sync(): void
    {
        $config = $this->allConfigTransformedKeyValue();
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

        $this->specialSync();
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

    private function specialSync(): void
    {
        $smsService = ucfirst(config('meedu.system.sms'));
        app()->instance(SmsInterface::class, app()->make('App\\Meedu\\Sms\\' . $smsService));
    }

    public function getCanEditConfig(): array
    {
        return $this->configService->all();
    }

    private function removeUnChange(array $config): array
    {
        $privateVal = str_pad('', 12, '*');
        foreach ($config as $key => $val) {
            if ($val === $privateVal) {
                unset($config[$key]);
            }
        }
        return $config;
    }
}
