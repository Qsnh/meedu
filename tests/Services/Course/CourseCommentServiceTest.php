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

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\CourseComment;
use App\Services\Member\Services\NotificationService;
use App\Services\Course\Services\CourseCommentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Course\Interfaces\CourseCommentServiceInterface;

class CourseCommentServiceTest extends TestCase
{

    /**
     * @var CourseCommentService
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
        $user = factory(User::class)->create();
        Auth::login($user);
        $course = factory(Course::class)->create();

        $comment = $this->service->create($course->id, '我是评价的内容');

        $this->assertEquals('我是评价的内容', $comment['original_content']);
        $this->assertEquals($user->id, $comment['user_id']);
    }

    public function test_create_with_at()
    {
        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        Auth::login($user);
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);

        $content = '我是@' . $user1->nick_name . ' 评价的内容';
        $comment = $this->service->create($course->id, $content);

        $this->assertEquals($content, $comment['original_content']);
        $this->assertEquals($user->id, $comment['user_id']);

        $this->assertEquals(1, $this->notificationService->getUserUnreadCount($user1->id));
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


    public function test_find_with_not_exists()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->service->find(12);
    }

    public function test_find()
    {
        $comment = factory(CourseComment::class)->create();
        $c = $this->service->find($comment->id);
        $this->assertEquals($comment->original_content, $c['original_content']);
    }
}
