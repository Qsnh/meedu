<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Constant\ConfigConstant;
use App\Events\AppConfigSavedEvent;
use App\Bus\AliyunVodCallbackSyncBus;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AliyunVodCallbackUrlListener
{
    public $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Handle the event.
     *
     * @param \App\Events\AppConfigSavedEvent $event
     * @return void
     */
    public function handle(AppConfigSavedEvent $event)
    {
        $config = $this->configService->getChunksConfigValues([
            ConfigConstant::ALIYUN_VOD_ACCESS_KEY_ID,
            ConfigConstant::ALIYUN_VOD_ACCESS_KEY_SECRET,
            ConfigConstant::ALIYUN_VOD_REGION,
            ConfigConstant::ALIYUN_VOD_HOST,
            ConfigConstant::ALIYUN_VOD_CALLBACK_KEY,
        ]);

        $bus = new AliyunVodCallbackSyncBus();
        $bus->handler([
            'region' => $config[ConfigConstant::ALIYUN_VOD_REGION],
            'host' => $config[ConfigConstant::ALIYUN_VOD_HOST],
            'access_key_id' => $config[ConfigConstant::ALIYUN_VOD_ACCESS_KEY_ID],
            'access_key_secret' => $config[ConfigConstant::ALIYUN_VOD_ACCESS_KEY_SECRET],
            'callback_key' => $config[ConfigConstant::ALIYUN_VOD_CALLBACK_KEY],
        ]);
    }
}
