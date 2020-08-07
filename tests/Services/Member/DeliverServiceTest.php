<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Services\Member;

use Carbon\Carbon;
use Tests\TestCase;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Services\DeliverService;
use App\Services\Member\Interfaces\DeliverServiceInterface;

class DeliverServiceTest extends TestCase
{

    /**
     * @var DeliverService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(DeliverServiceInterface::class);
    }

    public function test_deliverCourse()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $charge = random_int(0, 10);
        $this->service->deliverCourse($user->id, $course->id, $charge);
        $userCourse = UserCourse::whereUserId($user->id)->whereCourseId($course->id)->get();
        $this->assertEquals(1, $userCourse->count());
    }

    public function test_deliverVideo()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create();
        $charge = random_int(0, 10);
        $this->service->deliverVideo($user->id, $video->id, $charge);
        $userVideo = UserVideo::whereUserId($user->id)->whereVideoId($video->id)->get();
        $this->assertEquals(1, $userVideo->count());
    }

    public function test_deliverRole()
    {
        $role = factory(Role::class)->create([
            'expire_days' => random_int(1, 100),
        ]);
        $user = factory(User::class)->create([
            'role_id' => 0,
        ]);
        $charge = random_int(0, 100);
        $this->service->deliverRole($user->id, $role->id, $charge);
        $user->refresh();
        $this->assertEquals($role->id, $user->role_id);
        $this->assertEquals(Carbon::now()->addDays($role->expire_days)->format('Ymd'), Carbon::parse($user->role_expired_at)->format('Ymd'));
    }

    public function test_deliverRole_with_continue()
    {
        $role = factory(Role::class)->create([
            'expire_days' => random_int(1, 100),
        ]);
        $at = Carbon::now()->addMonths(1);
        $user = factory(User::class)->create([
            'role_id' => $role->id,
            'role_expired_at' => $at,
        ]);
        $charge = random_int(0, 100);
        $this->service->deliverRole($user->id, $role->id, $charge);
        $user->refresh();
        $this->assertEquals($role->id, $user->role_id);
        $this->assertEquals($at->addDays($role->expire_days)->toDateTimeString(), $user->role_expired_at);
    }
}
