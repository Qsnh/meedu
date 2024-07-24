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
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Meedu\ServiceV2\Services\ConfigServiceInterface;

class TencentPlayKeySyncListener implements ShouldQueue
{
    use InteractsWithQueue;

    public $configService;

    public function __construct(ConfigServiceInterface $configService)
    {
        $this->configService = $configService;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AppConfigSavedEvent  $event
     * @return void
     */
    public function handle(AppConfigSavedEvent $event)
    {
        $config = $this->configService->getChunksConfigValues([
            ConfigConstant::TENCENT_VOD_APP_ID,
            ConfigConstant::TENCENT_VOD_SECRET_ID,
            ConfigConstant::TENCENT_VOD_SECRET_KEY,
            ConfigConstant::TENCENT_VOD_PLAY_DOMAIN,
            ConfigConstant::TENCENT_VOD_PLAY_KEY,
        ]);

        $newConfig = [];
        foreach ($config as $key => $value) {
            $newConfig[str_replace(ConfigConstant::TENCENT_VOD_PREFIX, '', $key)] = $value;
        }

        (new TencentVodBus($newConfig))->playKeySync();
    }
}
