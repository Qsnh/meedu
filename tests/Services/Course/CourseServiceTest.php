<?php


namespace Tests\Services\Course;


use App\Services\Course\Models\Course;
use App\Services\Course\Services\CourseService;
use Carbon\Carbon;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{

    /**
     * @var CourseService
     */
    protected $courseService;

    public function setUp()
    {
        parent::setUp();
        $this->courseService = $this->app->make(CourseService::class);
    }

    public function test_simplePage()
    {
        $pageSize = mt_rand(1, 10);
        $total = mt_rand(15, 20);
        factory(Course::class, $total)->create([
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $list = $this->courseService->simplePage(1, $pageSize);

        $this->assertEquals($pageSize, count($list['list']));
        $this->assertEquals($total, $list['total']);
    }

}