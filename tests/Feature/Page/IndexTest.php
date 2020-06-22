<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
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
            'name' => '小滕博客',
            'url' => 'https://58hualong.cn',
        ]);

        $this->visit('/')->see('小滕博客')
            ->see('//58hualong.cn');
    }
}
