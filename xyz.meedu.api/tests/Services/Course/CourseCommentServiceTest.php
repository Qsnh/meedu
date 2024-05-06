<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Course;

use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseComment;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

class CourseCommentServiceTest extends TestCase
{

    /**
     * @var CourseCommentServiceInterface
     */
    protected $service;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(CourseCommentServiceInterface::class);
        $this->notificationService = $this->app->make(NotificationServiceInterface::class);
    }

    public function test_create()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $comment = $this->service->create($user['id'], $course->id, '我是评价的内容');

        $this->assertEquals('我是评价的内容', $comment['original_content']);
        $this->assertEquals($user->id, $comment['user_id']);
    }

    public function test_courseComments()
    {
        $course = Course::factory()->create();
        $comments = CourseComment::factory()->count(10)->create([
            'course_id' => $course,
            'user_id' => 1,
        ]);

        $list = $this->service->courseComments($course->id);
        $this->assertEquals($comments->count(), count($list));
    }
}
