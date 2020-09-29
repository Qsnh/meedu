<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Meedu\Cache\Inc;

use App\Constant\CacheConstant;
use App\Services\Base\Services\CacheService;
use App\Services\Other\Services\AdFromService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Other\Interfaces\AdFromServiceInterface;

class AdFromIncItem extends IncItem
{
    protected $adFrom;

    protected $inc = 1;
    protected $limit = 100;

    public function __construct(array $adFrom)
    {
        $this->adFrom = $adFrom;
    }

    public function getKey(): string
    {
        return get_cache_key(CacheConstant::AD_FROM_INCREMENT_['name'], $this->adFrom['from_key'], date('Y-m-d'));
    }

    public function save(): void
    {
        /**
         * @var $cacheService CacheService
         */
        $cacheService = app()->make(CacheServiceInterface::class);
        $val = $cacheService->pull($this->getKey());
        /**
         * @var $adFromService AdFromService
         */
        $adFromService = app()->make(AdFromServiceInterface::class);
        $today = date('Y-m-d');
        $adFromDay = $adFromService->getDay($this->adFrom['id'], $today);
        if ($adFromDay) {
            // 存在，直接写入
            $adFromService->updateDay($adFromDay['id'], ['num' => $adFromDay['num'] + $val]);
        } else {
            // 需要创建一条新的记录
            $adFromService->createDay($this->adFrom['id'], $today, (int)$val);
        }
    }
}
