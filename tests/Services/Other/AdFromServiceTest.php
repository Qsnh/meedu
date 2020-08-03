<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Services\Other;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Other\Models\AdFrom;
use App\Services\Other\Models\AdFromNumber;
use App\Services\Other\Services\AdFromService;
use App\Services\Other\Interfaces\AdFromServiceInterface;

class AdFromServiceTest extends TestCase
{

    /**
     * @var AdFromService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(AdFromServiceInterface::class);
    }

    public function test_all()
    {
        factory(AdFrom::class, 9)->create();
        $all = $this->service->all();
        $this->assertEquals(9, count($all));
    }

    public function test_getDay()
    {
        $number = factory(AdFromNumber::class)->create();
        $day = $this->service->getDay($number->from_id, $number->day);
        $this->assertNotEmpty($day);
    }

    public function test_updateDay()
    {
        $number = factory(AdFromNumber::class)->create();
        $num = $number->num + 5;
        $this->service->updateDay($number->id, [
            'num' => $number->num + 5,
        ]);
        $number->refresh();
        $this->assertEquals($num, $number->num);
    }

    public function test_createDay()
    {
        $from = factory(AdFrom::class)->create();
        $date = Carbon::now()->format('Y-m-d');
        $num = random_int(1, 1000);
        $this->service->createDay($from->id, $date, $num);

        $number = $this->service->getDay($from->id, $date);

        $this->assertEquals($num, $number['num']);
    }
}
