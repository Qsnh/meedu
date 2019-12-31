<?php


namespace Tests\Unit;


use App\Businesses\BusinessState;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\Video;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserVideo;
use Tests\TestCase;

class BusinessStateTest extends TestCase
{

    /**
     * @var BusinessState
     */
    protected $businessStatus;

    public function setUp()
    {
        parent::setUp();
        $this->businessStatus = $this->app->make(BusinessState::class);
    }

    public function test_canSeeVideo()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create(['charge' => 1]);

        // 视频免费
        $this->assertFalse($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_free_video()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create(['charge' => 0]);

        // 视频免费
        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_no_role()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create(['charge' => 1]);

        // 没有会员
        $this->assertFalse($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_buy_course()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create(['charge' => 1]);

        // 买了课程
        factory(UserCourse::class)->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_buy_video()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create(['charge' => 1]);

        // 买了课程
        factory(UserVideo::class)->create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

}