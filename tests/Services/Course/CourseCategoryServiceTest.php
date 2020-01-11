<?php


namespace Tests\Services\Course;


use App\Services\Course\Interfaces\CourseCategoryServiceInterface;
use App\Services\Course\Models\CourseCategory;
use App\Services\Course\Services\CourseCategoryService;
use Tests\TestCase;

class CourseCategoryServiceTest extends TestCase
{
    /**
     * @var CourseCategoryService
     */
    protected $service;

    public function setUp()
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