<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\AppConfigSavedEvent;

use App\Bus\AliVodBus;
use App\Constant\ConfigConstant;
use App\Events\AppConfigSavedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class AliyunPlayKeySyncListener implements ShouldQueue
{
    use InteractsWithQueue;

    private $configService;

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
            ConfigConstant::ALIYUN_VOD_PLAY_DOMAIN,
            ConfigConstant::ALIYUN_VOD_PLAY_KEY,
        ]);

        $newConfig = [];
        foreach ($config as $keyName => $keyValue) {
            $newConfig[str_replace(ConfigConstant::ALIYUN_VOD_PREFIX, '', $keyName)] = $keyValue;
        }

        (new AliVodBus($newConfig))->playKeySync();
    }
}
