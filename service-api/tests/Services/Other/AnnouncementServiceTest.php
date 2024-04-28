<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Other;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Other\Models\Announcement;
use App\Services\Other\Interfaces\AnnouncementServiceInterface;

class AnnouncementServiceTest extends TestCase
{

    /**
     * @var AnnouncementServiceInterface
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(AnnouncementServiceInterface::class);
    }


    public function test_latest()
    {
        $announce = Announcement::factory()->create([
            'admin_id' => 0,
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $latest = $this->service->latest();

        $this->assertEquals($announce['admin_id'], $latest['admin_id']);
        $this->assertEquals($announce['announcement'], $latest['announcement']);

        $newAnnouncement = Announcement::factory()->create([
            'admin_id' => 1,
        ]);
        $latest = $this->service->latest();

        $this->assertEquals($newAnnouncement->admin_id, $latest['admin_id']);
        $this->assertEquals($newAnnouncement->announcement, $latest['announcement']);
    }
}
