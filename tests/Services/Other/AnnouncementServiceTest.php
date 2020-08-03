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
use App\Services\Other\Models\Announcement;
use App\Services\Other\Services\AnnouncementService;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementServiceTest extends TestCase
{

    /**
     * @var AnnouncementService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(AnnouncementServiceInterface::class);
    }

    public function test_latest_with_cache()
    {
        config(['meedu.system.cache.status' => 1]);

        $announce = factory(Announcement::class)->create([
            'admin_id' => 0,
        ]);

        $latest = $this->service->latest();

        $this->assertEquals($announce['admin_id'], $latest['admin_id']);
        $this->assertEquals($announce['announcement'], $latest['announcement']);

        $newAnnouncement = factory(Announcement::class)->create([
            'admin_id' => 1,
        ]);
        $latest = $this->service->latest();

        $this->assertEquals($announce['admin_id'], $latest['admin_id']);
        $this->assertEquals($announce['announcement'], $latest['announcement']);
    }

    public function test_latest_with_no_cache()
    {
        config(['meedu.system.cache.status' => 0]);

        $announce = factory(Announcement::class)->create([
            'admin_id' => 0,
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $latest = $this->service->latest();

        $this->assertEquals($announce['admin_id'], $latest['admin_id']);
        $this->assertEquals($announce['announcement'], $latest['announcement']);

        $newAnnouncement = factory(Announcement::class)->create([
            'admin_id' => 1,
        ]);
        $latest = $this->service->latest();

        $this->assertEquals($newAnnouncement->admin_id, $latest['admin_id']);
        $this->assertEquals($newAnnouncement->announcement, $latest['announcement']);
    }
}
