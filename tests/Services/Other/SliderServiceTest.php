<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 */

namespace Tests\Services\Other;

use Tests\TestCase;
use App\Services\Other\Models\Slider;
use App\Services\Other\Services\SliderService;
use App\Services\Other\Interfaces\SliderServiceInterface;

class SliderServiceTest extends TestCase
{

    /**
     * @var SliderService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(SliderServiceInterface::class);
    }

    public function test_all()
    {
        factory(Slider::class, 3)->create();

        $data = $this->service->all();

        $this->assertCount(3, $data);
    }

    public function test_all_with_platform()
    {
        factory(Slider::class, 3)->create([
            'platform' => 'PC',
        ]);

        factory(Slider::class, 3)->create([
            'platform' => 'H5',
        ]);

        $data = $this->service->all('PC');

        $this->assertCount(3, $data);
    }

    public function test_all_with_cache()
    {
        factory(Slider::class, 3)->create();

        // 开启缓存
        config(['meedu.system.cache.status' => 1]);

        $data = $this->service->all();

        $this->assertCount(3, $data);

        // 再生成2个
        factory(Slider::class, 2)->create();

        $data = $this->service->all();
        // 依旧为3个
        $this->assertCount(3, $data);

        config(['meedu.system.cache.status' => 0]);
    }

    public function test_all_with_cache_with_platform()
    {
        factory(Slider::class, 3)->create([
            'platform' => 'PC',
        ]);
        factory(Slider::class, 2)->create([
            'platform' => 'H5',
        ]);

        // 开启缓存
        config(['meedu.system.cache.status' => 1]);

        $data = $this->service->all('PC');

        $this->assertCount(3, $data);

        // 再生成2个
        factory(Slider::class, 2)->create([
            'platform' => 'PC',
        ]);
        factory(Slider::class, 2)->create([
            'platform' => 'H5',
        ]);

        $data = $this->service->all('PC');
        // 依旧为3个
        $this->assertCount(3, $data);

        config(['meedu.system.cache.status' => 0]);

        $data = $this->service->all('PC');
        // 为5个
        $this->assertCount(5, $data);
    }
}
