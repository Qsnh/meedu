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

        $link = factory(Link::class)->create([
            'sort' => 1,
        ]);

        $links = $this->service->all();

        $this->assertEquals(1, count($links));
        $this->assertEquals($link->sort, $links[0]['sort']);
        $this->assertEquals($link->name, $links[0]['name']);
        $this->assertEquals($link->url, $links[0]['url']);

        $link1 = factory(Link::class)->create([
            'sort' => 2,
        ]);
        $links = $this->service->all();

        $this->assertEquals(1, count($links));
        $this->assertEquals($link->name, $links[0]['name']);
    }

    public function test_link_all_with_no_cache()
    {
        config(['meedu.system.cache.status' => 0]);

        $link = factory(Link::class)->create([
            'sort' => 1,
        ]);

        $links = $this->service->all();

        $this->assertEquals(1, count($links));
        $this->assertEquals($link->sort, $links[0]['sort']);
        $this->assertEquals($link->name, $links[0]['name']);
        $this->assertEquals($link->url, $links[0]['url']);

        $link1 = factory(Link::class)->create([
            'sort' => 2,
        ]);
        $links = $this->service->all();

        $this->assertEquals(2, count($links));
        $this->assertEquals($link->name, $links[0]['name']);
        $this->assertEquals($link1->name, $links[1]['name']);
    }
}
