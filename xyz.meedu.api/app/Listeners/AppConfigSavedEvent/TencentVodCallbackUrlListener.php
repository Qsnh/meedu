<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Bus\TencentVodBus;
use App\Constant\ConfigConstant;
use App\Events\AppConfigSavedEvent;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class TencentVodCallbackUrlListener
{
    public $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    public function handle(AppConfigSavedEvent $event)
    {
        $config = $this->configService->getChunksConfigValues([
            ConfigConstant::TENCENT_VOD_APP_ID,
            ConfigConstant::TENCENT_VOD_SECRET_ID,
            ConfigConstant::TENCENT_VOD_SECRET_KEY,
            ConfigConstant::TENCENT_VOD_CALLBACK_KEY,
        ]);

        $newConfig = [];
        foreach ($config as $key => $value) {
            $newConfig[str_replace(ConfigConstant::TENCENT_VOD_PREFIX, '', $key)] = $value;
        }

        (new TencentVodBus($newConfig))->callbackSync();
    }
}
