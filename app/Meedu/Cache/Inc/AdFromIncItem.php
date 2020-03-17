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

use App\Services\Base\Services\CacheService;
use App\Services\Other\Services\AdFromService;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Other\Interfaces\AdFromServiceInterface;

class AdFromIncItem implements IncItem
{
    protected $adFrom;

    public $inc = 1;
    public $limit = 50;

    public function __construct(array $adFrom)
    {
        $this->adFrom = $adFrom;
    }

    public function getKey(): string
    {
        return sprintf('ad_from_%s_%s', $this->adFrom['from_key'], date('Y-m-d'));
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
        $cacheService->forget($this->getKey());
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
