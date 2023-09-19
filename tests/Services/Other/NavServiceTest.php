<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Other;

use Tests\TestCase;
use App\Constant\FrontendConstant;
use App\Services\Other\Models\Nav;
use App\Services\Other\Interfaces\NavServiceInterface;

class NavServiceTest extends TestCase
{

    /**
     * @var NavServiceInterface
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(NavServiceInterface::class);
    }

    public function test_all()
    {
        $platform = 'pc';

        $nav = Nav::factory()->create(['sort' => 1, 'platform' => $platform]);

        $all = $this->service->all($platform);

        $this->assertEquals(1, count($all));
        $this->assertEquals($nav->sort, $all[0]['sort']);
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav->url, $all[0]['url']);

        // 再创建一个
        $nav2 = Nav::factory()->create(['sort' => 2, 'platform' => $platform]);

        $all = $this->service->all($platform);

        $this->assertEquals(2, count($all));
        // sort升序
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav2->name, $all[1]['name']);
    }

    public function test_platform()
    {
        $platform = FrontendConstant::NAV_PLATFORM_PC;
        Nav::factory()->count(3)->create([
            'platform' => $platform,
        ]);
        Nav::factory()->count(2)->create([
            'platform' => FrontendConstant::NAV_PLATFORM_H5,
        ]);

        $navs = $this->service->all($platform);
        $this->assertEquals(3, count($navs));

        $this->assertEquals(5, count($this->service->all()));
    }
}
