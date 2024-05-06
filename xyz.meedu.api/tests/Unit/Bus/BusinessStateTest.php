<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Bus;

use Carbon\Carbon;
use Tests\TestCase;
use App\Businesses\BusinessState;
use App\Constant\FrontendConstant;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Order\Models\PromoCode;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Order\Models\OrderPaidRecord;

class BusinessStateTest extends TestCase
{

    /**
     * @var BusinessState
     */
    protected $businessStatus;

    public function setUp(): void
    {
        parent::setUp();
        $this->businessStatus = $this->app->make(BusinessState::class);
    }

    public function test_canSeeVideo()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $video = Video::factory()->create(['charge' => 1]);

        // 视频免费
        $this->assertFalse($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_free_course()
    {
        $course = Course::factory()->create(['is_free' => 1]);
        $video = Video::factory()->create(['course_id' => $course['id'], 'charge' => 1]);
        $user = User::factory()->create();
        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_no_role()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $video = Video::factory()->create(['charge' => 1]);

        // 没有会员
        $this->assertFalse($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_role()
    {
        $user = User::factory()->create([
            'role_id' => 1,
            'role_expired_at' => Carbon::now()->addDays(1),
        ]);
        $course = Course::factory()->create();
        $video = Video::factory()->create(['charge' => 1]);

        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_buy_course()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $video = Video::factory()->create(['charge' => 1]);

        // 买了课程
        UserCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_canSeeVideo_with_buy_video()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $video = Video::factory()->create(['charge' => 1]);

        // 买了课程
        UserVideo::factory()->create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
    }

    public function test_isRole()
    {
        $user = User::factory()->create([
            'role_id' => 0,
            'role_expired_at' => null,
        ]);
        $this->assertFalse($this->businessStatus->isRole($user->toArray()));

        $user->role_id = 1;
        $user->save();
        $this->assertFalse($this->businessStatus->isRole($user->toArray()));

        $user->role_expired_at = Carbon::now()->subDays(1);
        $user->save();
        $this->assertFalse($this->businessStatus->isRole($user->toArray()));

        $user->role_expired_at = Carbon::now()->addDays(1);
        $user->save();
        $this->assertTrue($this->businessStatus->isRole($user->toArray()));
    }

    public function test_promoCodeCanUse_with_self()
    {
        $user = User::factory()->create();
        $promoCode = PromoCode::factory()->create(['user_id' => $user->id]);
        $this->assertFalse($this->businessStatus->promoCodeCanUse($user['id'], $promoCode->toArray()));
    }

    public function test_promoCodeCanUse_with_used_times()
    {
        $user = User::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'user_id' => $user->id + 1,
            'used_times' => 1,
            'use_times' => 1,
        ]);
        $this->assertFalse($this->businessStatus->promoCodeCanUse($user['id'], $promoCode->toArray()));
    }

    public function test_promoCodeCanUse_with_used()
    {
        $user = User::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'user_id' => $user['id'] + 1,
        ]);
        OrderPaidRecord::factory()->create([
            'user_id' => $user['id'],
            'paid_total' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
            'paid_type_id' => $promoCode->id,
        ]);
        $this->assertFalse($this->businessStatus->promoCodeCanUse($user['id'], $promoCode->toArray()));
    }

    public function test_orderIsPaid()
    {
        $this->assertTrue($this->businessStatus->orderIsPaid(['status' => FrontendConstant::ORDER_PAID]));
        $this->assertFalse($this->businessStatus->orderIsPaid(['status' => FrontendConstant::ORDER_UN_PAY]));
    }

    public function test_isEnabledMpOAuthLogin()
    {
        //默认关闭
        $this->assertFalse($this->businessStatus->isEnabledMpOAuthLogin());

        config(['meedu.mp_wechat.enabled_oauth_login' => 1]);
        $this->assertTrue($this->businessStatus->isEnabledMpOAuthLogin());
    }

    public function test_enabledMpScanLogin()
    {
        //默认关闭
        $this->assertFalse($this->businessStatus->enabledMpScanLogin());

        config(['meedu.mp_wechat.enabled_scan_login' => 1]);
        $this->assertTrue($this->businessStatus->enabledMpScanLogin());
    }

    public function test_isBuyCourse_with_free_course()
    {
        $course = Course::factory()->create(['is_free' => 1]);
        $user = User::factory()->create();
        $this->assertTrue($this->businessStatus->isBuyCourse($user['id'], $course['id']));
    }

    public function test_courseCanComment_with_free_course()
    {
        $course = Course::factory()->create(['is_free' => 1]);
        $user = User::factory()->create();
        $this->assertTrue($this->businessStatus->courseCanComment($user->toArray(), $course->toArray()));
    }

    public function test_courseCanComment_with_charge_course()
    {
        $course = Course::factory()->create(['is_free' => 0, 'charge' => 100]);
        $user = User::factory()->create();
        $this->assertFalse($this->businessStatus->courseCanComment($user->toArray(), $course->toArray()));
    }

    public function test_courseCanComment_with_charge_course_and_paid()
    {
        $course = Course::factory()->create(['is_free' => 0, 'charge' => 100]);
        $user = User::factory()->create();
        UserCourse::create(['user_id' => $user['id'], 'course_id' => $course['id']]);
        $this->assertTrue($this->businessStatus->courseCanComment($user->toArray(), $course->toArray()));
    }

    public function test_courseCanComment_with_charge_course_and_role()
    {
        $course = Course::factory()->create(['is_free' => 0, 'charge' => 100]);
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role['id'], 'role_expired_at' => Carbon::now()->addDays(1)->toDateTimeLocalString()]);
        $this->assertTrue($this->businessStatus->courseCanComment($user->toArray(), $course->toArray()));
    }

    public function test_videoCanComment_with_free_course()
    {
        $course = Course::factory()->create(['is_free' => 1]);
        $user = User::factory()->create();
        $video = Video::factory()->create(['course_id' => $course['id'], 'charge' => 100]);
        $this->assertTrue($this->businessStatus->videoCanComment($user->toArray(), $video->toArray()));
    }

    public function test_videoCanComment_with_charge_course_and_paid()
    {
        $course = Course::factory()->create(['is_free' => 0, 'charge' => 100]);
        $user = User::factory()->create();
        $video = Video::factory()->create(['course_id' => $course['id'], 'charge' => 100]);
        UserCourse::create(['user_id' => $user['id'], 'course_id' => $course['id']]);
        $this->assertTrue($this->businessStatus->videoCanComment($user->toArray(), $video->toArray()));
    }

    public function test_videoCanComment_with_charge_course_and_with_role()
    {
        $course = Course::factory()->create(['is_free' => 0, 'charge' => 100]);
        $video = Video::factory()->create(['course_id' => $course['id'], 'charge' => 100]);
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role['id'], 'role_expired_at' => Carbon::now()->addDays(1)->toDateTimeLocalString()]);
        $this->assertTrue($this->businessStatus->videoCanComment($user->toArray(), $video->toArray()));
    }

    public function test_videoCanComment_with_charge()
    {
        $course = Course::factory()->create(['is_free' => 0, 'charge' => 100]);
        $video = Video::factory()->create(['course_id' => $course['id'], 'charge' => 100]);
        $user = User::factory()->create();
        $this->assertFalse($this->businessStatus->videoCanComment($user->toArray(), $video->toArray()));
    }
}
