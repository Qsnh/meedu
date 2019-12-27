<?php


namespace Tests\Services\Course;


use App\Services\Course\Interfaces\CourseCommentServiceInterface;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseComment;
use App\Services\Course\Services\CourseCommentService;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class CourseCommentServiceTest extends TestCase
{

    /**
     * @var CourseCommentService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(CourseCommentServiceInterface::class);
    }

    public function test_create()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $course = factory(Course::class)->create();

        $comment = $this->service->create($course->id, '我是评价的内容');

        $this->assertEquals('我是评价的内容', $comment['original_content']);
        $this->assertEquals($user->id, $comment['user_id']);
    }

    public function test_courseComments()
    {
        $course = factory(Course::class)->create();
        $comments = factory(CourseComment::class, 10)->create([
            'course_id' => $course,
            'user_id' => 1,
        ]);

        $list = $this->service->courseComments($course->id);
        $this->assertEquals($comments->count(), count($list));
    }

}