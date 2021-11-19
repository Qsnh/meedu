<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Businesses\BusinessState;
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

    public function test_canSeeVideo_with_free_video()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $video = Video::factory()->create(['charge' => 0]);

        // 视频免费
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

    public function test_canGenerateInviteCode()
    {
        $user = User::factory()->create([
            'role_id' => 0,
        ]);

        // 免费用户无法生成邀请码
        config(['meedu.member.invite.free_user_enabled' => 0]);
        $this->assertFalse($this->businessStatus->canGenerateInviteCode($user->toArray()));

        // 免费用户可以生成邀请码
        config(['meedu.member.invite.free_user_enabled' => 1]);
        $this->assertTrue($this->businessStatus->canGenerateInviteCode($user->toArray()));

        PromoCode::factory()->create([
            'user_id' => $user->id,
        ]);
        $this->assertFalse($this->businessStatus->canGenerateInviteCode($user->toArray()));
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

    public function test_promoCodeCanUse_with_invite_promo_code()
    {
        $user = User::factory()->create();
        $promoCode = PromoCode::factory()->create([
            'user_id' => $user->id + 1,
            'code' => 'U' . Str::random(),
        ]);
        $this->assertTrue($this->businessStatus->promoCodeCanUse($user['id'], $promoCode->toArray()));

        $user->is_used_promo_code = 1;
        $user->save();
        $this->assertFalse($this->businessStatus->promoCodeCanUse($user['id'], $promoCode->toArray()));
    }

    public function test_promoCodeCanUse_with_simple_promo_code()
    {
        $user = User::factory()->create([
            'is_used_promo_code' => 1,
        ]);
        $promoCode = PromoCode::factory()->create([
            'user_id' => $user->id + 1,
            'code' => 'S' . Str::random(),
        ]);
        $this->assertTrue($this->businessStatus->promoCodeCanUse($user['id'], $promoCode->toArray()));
    }
}
