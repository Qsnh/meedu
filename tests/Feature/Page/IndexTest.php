<?php

namespace Tests\Feature\Page;

use App\Services\Course\Models\Course;
use App\Services\Other\Models\Link;
use Carbon\Carbon;
use Tests\TestCase;

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
