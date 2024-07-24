<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Constant\ConfigConstant;
use App\Events\AppConfigSavedEvent;
use App\Bus\TencentVodCallbackSyncBus;
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
            ConfigConstant::TENCENT_VOD_PLAY_DOMAIN,
        ]);

        $bus = new TencentVodCallbackSyncBus();

        $bus->handler([
            'app_id' => $config[ConfigConstant::TENCENT_VOD_APP_ID],
            'secret_id' => $config[ConfigConstant::TENCENT_VOD_SECRET_ID],
            'secret_key' => $config[ConfigConstant::TENCENT_VOD_SECRET_KEY],
            'callback_key' => $config[ConfigConstant::TENCENT_VOD_CALLBACK_KEY],
            'play_domain' => $config[ConfigConstant::TENCENT_VOD_PLAY_DOMAIN],
        ]);
    }
}
