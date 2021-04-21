<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace Tests\Services\Other;

use Tests\TestCase;
use App\Services\Other\Models\IndexBanner;
use App\Services\Other\Services\IndexBannerService;
use App\Services\Other\Interfaces\IndexBannerServiceInterface;

class IndexBannerServiceTest extends TestCase
{


    /**
     * @var IndexBannerService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(IndexBannerServiceInterface::class);
    }

    public function test_all()
    {
        factory(IndexBanner::class, 3)->create();

        $data = $this->service->all();

        $this->assertCount(3, $data);
    }

    public function test_all_with_cache()
    {
        factory(IndexBanner::class, 3)->create();

        // 开启缓存
        config(['meedu.system.cache.status' => 1]);

        $data = $this->service->all();

        $this->assertCount(3, $data);

        // 再生成2个
        factory(IndexBanner::class, 2)->create();

        $data = $this->service->all();
        // 依旧为3个
        $this->assertCount(3, $data);

        config(['meedu.system.cache.status' => 0]);
    }
}
