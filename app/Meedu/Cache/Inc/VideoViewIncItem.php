<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Meedu\Cache\Inc;

use App\Constant\CacheConstant;
use App\Services\Base\Services\CacheService;
use App\Services\Course\Services\VideoService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Course\Interfaces\VideoServiceInterface;

class VideoViewIncItem extends IncItem
{
    protected $videoId;

    protected $inc = 1;
    protected $limit = 100;

    public function __construct($videoId)
    {
        $this->videoId = $videoId;
    }

    public function getKey(): string
    {
        return get_cache_key(CacheConstant::VIDEO_VIEW_INCREMENT['name'], $this->videoId);
    }

    public function save(): void
    {
        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $val = (int)$cacheService->pull($this->getKey());

        /**
         * @var VideoService $videoService
         */
        $videoService = app()->make(VideoServiceInterface::class);
        $videoService->viewNumIncrement($this->videoId, $val);
    }
}
