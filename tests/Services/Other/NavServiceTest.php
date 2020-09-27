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

use Tests\TestCase;
use App\Constant\FrontendConstant;
use App\Services\Other\Models\Nav;
use App\Services\Other\Services\NavService;
use App\Services\Other\Interfaces\NavServiceInterface;

class NavServiceTest extends TestCase
{

    /**
     * @var NavService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(NavServiceInterface::class);
    }

    public function test_all_with_cache()
    {
        // 开启缓存
        config(['meedu.system.cache.status' => 1]);

        $platform = 'pc';

        $nav = factory(Nav::class)->create(['sort' => 1, 'platform' => $platform]);

        $all = $this->service->all($platform);

        $this->assertEquals(1, count($all));
        $this->assertEquals($nav->sort, $all[0]['sort']);
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav->url, $all[0]['url']);

        // 再创建一个
        $nav1 = factory(Nav::class)->create(['sort' => 2, 'platform' => $platform]);
        $all = $this->service->all($platform);

        $this->assertEquals(1, count($all));
        $this->assertEquals($nav->name, $all[0]['name']);
    }

    public function test_all_with_no_cache()
    {
        // 开启缓存
        config(['meedu.system.cache.status' => 0]);

        $platform = 'pc';

        $nav = factory(Nav::class)->create(['sort' => 1, 'platform' => $platform]);

        $all = $this->service->all($platform);

        $this->assertEquals(1, count($all));
        $this->assertEquals($nav->sort, $all[0]['sort']);
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav->url, $all[0]['url']);

        // 再创建一个
        $nav2 = factory(Nav::class)->create(['sort' => 2, 'platform' => $platform]);

        $all = $this->service->all($platform);

        $this->assertEquals(2, count($all));
        // sort升序
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav2->name, $all[1]['name']);
    }

    public function test_platform()
    {
        $platform = FrontendConstant::NAV_PLATFORM_PC;
        factory(Nav::class, 3)->create([
            'platform' => $platform,
        ]);
        factory(Nav::class, 2)->create([
            'platform' => FrontendConstant::NAV_PLATFORM_H5,
        ]);

        $navs = $this->service->all($platform);
        $this->assertEquals(3, count($navs));

        $this->assertEquals(5, count($this->service->all()));
    }
}
