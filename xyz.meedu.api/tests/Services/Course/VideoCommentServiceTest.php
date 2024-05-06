<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Course;

use Tests\TestCase;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\VideoComment;
use App\Services\Member\Services\NotificationService;
use App\Services\Course\Interfaces\VideoCommentServiceInterface;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class VideoCommentServiceTest extends TestCase
{

    /**
     * @var VideoCommentServiceInterface
     */
    protected $service;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(VideoCommentServiceInterface::class);
        $this->notificationService = $this->app->make(NotificationServiceInterface::class);
    }

    public function test_create()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $comment = $this->service->create($user['id'], $video->id, '我是评价的内容');

        $this->assertEquals('我是评价的内容', $comment['original_content']);
        $this->assertEquals($user->id, $comment['user_id']);
    }

    public function test_courseComments()
    {
        $video = Video::factory()->create();
        $comments = VideoComment::factory()->count(10)->create([
            'video_id' => $video,
            'user_id' => 1,
        ]);

        $list = $this->service->videoComments($video->id);
        $this->assertEquals($comments->count(), count($list));
    }
}
