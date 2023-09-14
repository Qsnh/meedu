<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(CourseCategoryServiceInterface::class);
    }

    public function test_all()
    {
        CourseCategory::factory()->count(9)->create();
        CourseCategory::factory()->count(9)->create(['parent_id' => 1]);

        $res = $this->service->all();
        $this->assertEquals(9, count($res));
    }
}
