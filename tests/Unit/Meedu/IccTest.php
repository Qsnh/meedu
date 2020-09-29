<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Unit\Meedu;

use Tests\TestCase;
use App\Meedu\Cache\Inc\Inc;
use App\Services\Other\Models\AdFrom;
use App\Meedu\Cache\Inc\AdFromIncItem;
use App\Services\Other\Services\AdFromService;
use App\Services\Other\Interfaces\AdFromServiceInterface;

class IccTest extends TestCase
{
    public function test_AdFromIncItem()
    {
        $adFrom = factory(AdFrom::class)->create();
        $incItem = new AdFromIncItem($adFrom->toArray());
        $incItem->setLimit(2);
        $this->assertEquals(2, $incItem->getLimit());

        Inc::record($incItem);

        /**
         * @var $adFromService AdFromService
         */
        $adFromService = app()->make(AdFromServiceInterface::class);
        $today = date('Y-m-d');
        $adFromDay = $adFromService->getDay($adFrom->id, $today);
        $this->assertEmpty($adFromDay);

        Inc::record($incItem);
        $adFromDay = $adFromService->getDay($adFrom->id, $today);
        $this->assertEquals(2, $adFromDay['num']);

        // 未触发写入，所以还是之前的值
        Inc::record($incItem);
        $adFromDay = $adFromService->getDay($adFrom->id, $today);
        $this->assertEquals(2, $adFromDay['num']);

        // 触发写入，变为4
        Inc::record($incItem);
        $adFromDay = $adFromService->getDay($adFrom->id, $today);
        $this->assertEquals(4, $adFromDay['num']);
    }
}
