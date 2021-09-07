<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Page;

use Tests\TestCase;
use App\Services\Other\Models\Link;

class IndexTest extends TestCase
{
    // 可以正常访问首页
    public function test_visit()
    {
        $this->get(url('/'))->assertResponseStatus(200);
    }

    // 在首页可以看到添加的友情链接
    public function test_see_friendlink()
    {
        Link::create([
            'name' => 'meedu官网',
            'url' => 'https://meedu.vip',
        ]);

        $this->visit('/')->see('meedu官网')
            ->see('//meedu.vip');
    }
}
