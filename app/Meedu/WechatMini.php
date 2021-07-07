<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu;

use EasyWeChat\Factory;
use App\Services\Base\Services\ConfigService;
use App\Services\Base\Interfaces\ConfigServiceInterface;

class WechatMini
{
    private static $instance = null;

    private function __construct()
    {
    }

    /**
     * @return \EasyWeChat\MiniProgram\Application|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            /**
             * @var ConfigService $configService
             */
            $configService = app()->make(ConfigServiceInterface::class);

            self::$instance = Factory::miniProgram($configService->getTencentWechatMiniConfig());
        }

        return self::$instance;
    }
}
