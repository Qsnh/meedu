<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use EasyWeChat\Factory;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class Wechat
{
    private static $instance = null;

    private function __construct()
    {
    }

    /**
     * @return \EasyWeChat\OfficialAccount\Application|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            /**
             * @var ConfigServiceInterface $configService
             */
            $configService = app()->make(ConfigServiceInterface::class);
            $mpWechatConfig = $configService->getMpWechatConfig();
            $config = [
                'app_id' => $mpWechatConfig['app_id'],
                'secret' => $mpWechatConfig['app_secret'],
                'token' => $mpWechatConfig['token'],
                'aes_key' => $mpWechatConfig['aes_key'] ?? '',
                'response_type' => 'array',
                'log' => [
                    'default' => 'prod',
                    'channels' => [
                        'prod' => [
                            'driver' => 'daily',
                            'path' => storage_path('logs/wechat.log'),
                            'level' => 'info',
                        ],
                    ],
                ],
                'oauth' => [
                    'scopes' => ['snsapi_userinfo'],
                    'callback' => '',
                ],
            ];
            self::$instance = Factory::officialAccount($config);
        }

        return self::$instance;
    }
}
