<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Meedu;

use Tests\TestCase;
use App\Meedu\Cache\MemoryCache;

class MemoryCacheTest extends TestCase
{
    public function test_set_and_get_and_exists()
    {
        $instance = MemoryCache::getInstance();

        $instance->set('demo1', 1);
        $instance->set('demo2', false);
        $instance->set('demo3', 'string');

        $this->assertTrue($instance->exists('demo1'));
        $this->assertTrue($instance->exists('demo2'));
        $this->assertTrue($instance->exists('demo3'));
        $this->assertFalse($instance->exists('demo4'));

        $this->assertEquals(1, $instance->get('demo1'));
        $this->assertEquals(false, $instance->get('demo2'));
        $this->assertEquals('string', $instance->get('demo3'));
    }

    public function test_set_and_get_and_exists_and_in_closure()
    {
        call_user_func(function () {
            $cache = MemoryCache::getInstance();

            $cache->set('demo11', 1);
            $cache->set('demo22', false);
            $cache->set('demo33', 'string');
        });

        $instance = MemoryCache::getInstance();

        $this->assertEquals(1, $instance->get('demo11'));
        $this->assertEquals(false, $instance->get('demo22'));
        $this->assertEquals('string', $instance->get('demo33'));
    }

    public function test_set_and_exception()
    {
        $instance = MemoryCache::getInstance();

        $instance->set('haha123', 1);

        $this->expectExceptionMessage(sprintf('The key[%s] has exists', 'haha123'));

        $instance->set('haha123', 2, false);
    }

    public function test_set_force()
    {
        $instance = MemoryCache::getInstance();

        $instance->set('haha56', 1);
        $instance->set('haha56', 2, true);

        $this->assertEquals(2, $instance->get('haha56'));
    }
}
