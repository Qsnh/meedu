<?php


namespace Tests\Services\Other;

use App\Services\Other\Interfaces\NavServiceInterface;
use App\Services\Other\Models\Nav;
use App\Services\Other\Services\NavService;
use Tests\TestCase;

class NavServiceTest extends TestCase
{

    /**
     * @var NavService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(NavServiceInterface::class);
    }

    public function test_all_with_cache()
    {
        // 开启缓存
        config(['meedu.system.cache.status' => 1]);

        $nav = factory(Nav::class)->create(['sort' => 1]);

        $all = $this->service->all();

        $this->assertEquals(1, count($all));
        $this->assertEquals($nav->sort, $all[0]['sort']);
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav->url, $all[0]['url']);

        // 再创建一个
        $nav1 = factory(Nav::class)->create(['sort' => 2]);
        $all = $this->service->all();

        $this->assertEquals(1, count($all));
        $this->assertEquals($nav->name, $all[0]['name']);
    }

    public function test_all_with_no_cache()
    {
        // 开启缓存
        config(['meedu.system.cache.status' => 0]);

        $nav = factory(Nav::class)->create(['sort' => 1]);

        $all = $this->service->all();

        $this->assertEquals(1, count($all));
        $this->assertEquals($nav->sort, $all[0]['sort']);
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav->url, $all[0]['url']);

        // 再创建一个
        $nav2 = factory(Nav::class)->create(['sort' => 2]);

        $all = $this->service->all();

        $this->assertEquals(2, count($all));
        // sort升序
        $this->assertEquals($nav->name, $all[0]['name']);
        $this->assertEquals($nav2->name, $all[1]['name']);
    }

}