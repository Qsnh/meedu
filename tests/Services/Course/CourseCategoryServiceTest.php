<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Services\Course;

use Tests\TestCase;
use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Services\CourseCategoryService;
use App\Services\Course\Interfaces\CourseCategoryServiceInterface;

class CourseCategoryServiceTest extends TestCase
{
    /**
     * @var CourseCategoryService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(CourseCategoryServiceInterface::class);
    }

    public function test_all()
    {
        factory(CourseCategory::class, 10)->create();
        $res = $this->service->all();
        $this->assertEquals(10, count($res));
    }
}
