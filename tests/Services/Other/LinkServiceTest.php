<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Other;

use Tests\TestCase;
use App\Services\Other\Models\Link;
use App\Services\Other\Interfaces\LinkServiceInterface;

class LinkServiceTest extends TestCase
{
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(LinkServiceInterface::class);
    }

    public function test_link_all_with_cache()
    {
        config(['meedu.system.cache.status' => 1]);

        $link = Link::factory()->create([
            'sort' => 1,
        ]);

        $links = $this->service->all();

        $this->assertEquals(1, count($links));
        $this->assertEquals($link->sort, $links[0]['sort']);
        $this->assertEquals($link->name, $links[0]['name']);
        $this->assertEquals($link->url, $links[0]['url']);

        $link1 = Link::factory()->create([
            'sort' => 2,
        ]);
        $links = $this->service->all();

        $this->assertEquals(1, count($links));
        $this->assertEquals($link->name, $links[0]['name']);
    }

    public function test_link_all_with_no_cache()
    {
        config(['meedu.system.cache.status' => 0]);

        $link = Link::factory()->create([
            'sort' => 1,
        ]);

        $links = $this->service->all();

        $this->assertEquals(1, count($links));
        $this->assertEquals($link->sort, $links[0]['sort']);
        $this->assertEquals($link->name, $links[0]['name']);
        $this->assertEquals($link->url, $links[0]['url']);

        $link1 = Link::factory()->create([
            'sort' => 2,
        ]);
        $links = $this->service->all();

        $this->assertEquals(2, count($links));
        $this->assertEquals($link->name, $links[0]['name']);
        $this->assertEquals($link1->name, $links[1]['name']);
    }
}
