<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use App\Meedu\Sms\SmsInterface;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class Setting
{
    const VERSION = 1;

    protected $configService;

    /**
     * Setting constructor.
     * @param ConfigServiceInterface $configService
     */
    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * 追加配置（用来写入部分配置）
     * @param $config
     */
    public function append($config): void
    {
        $this->put($config);
    }

    /**
     * 将配置同步到laravel中
     */
    public function sync(): void
    {
        $config = $this->get();
        foreach ($config as $key => $item) {
            config([$key => $item]);
        }
        $this->specialSync();
    }

    /**
     * 一些特殊配置.
     */
    protected function specialSync(): void
    {
        // 短信服务注册
        $smsService = ucfirst(config('meedu.system.sms'));
        app()->instance(SmsInterface::class, app()->make('App\\Meedu\\Sms\\' . $smsService));
    }

    /**
     * 保存配置
     * @param array $setting
     */
    public function put(array $setting): void
    {
        $setting = $this->removeUnChange($setting);
        $this->configService->setConfig($setting);
    }

    /**
     * 读取配置
     * @return array
     */
    public function get(): array
    {
        try {
            $config = $this->configService->all();
            $data = [];
            foreach ($config as $item) {
                $data[$item['key']] = $item['value'];
            }
            return $data;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * 获取可以编辑的配置
     * @return array
     */
    public function getCanEditConfig(): array
    {
        return $this->configService->all();
    }

    /**
     * @param array $config
     * @return array
     */
    protected function removeUnChange(array $config): array
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
