<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Other;

use Tests\TestCase;
use App\Services\Other\Models\Slider;
use App\Services\Other\Interfaces\SliderServiceInterface;

class SliderServiceTest extends TestCase
{

    /**
     * @var SliderServiceInterface
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(SliderServiceInterface::class);
    }

    public function test_all()
    {
        Slider::factory()->count(3)->create();

        $data = $this->service->all();

        $this->assertCount(3, $data);
    }

    public function test_all_with_platform()
    {
        Slider::factory()->count(3)->create([
            'platform' => 'PC',
        ]);

        Slider::factory()->count(3)->create([
            'platform' => 'H5',
        ]);

        $data = $this->service->all('PC');

        $this->assertCount(3, $data);
    }
}
