<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Businesses\BusinessState;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public function setUp():void
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

    public function test_canSeeVideo_with_role()
    {
        $user = factory(User::class)->create([
            'role_id' => 1,
            'role_expired_at' => Carbon::now()->addDays(1),
        ]);
        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create(['charge' => 1]);

        $this->assertTrue($this->businessStatus->canSeeVideo($user->toArray(), $course->toArray(), $video->toArray()));
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

    public function test_isRole()
    {
        $user = factory(User::class)->create([
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
        $user = factory(User::class)->create([
            'role_id' => 0,
        ]);
        config(['meedu.member.invite.free_user_enabled' => 0]);
        $this->assertFalse($this->businessStatus->canGenerateInviteCode($user->toArray()));

        config(['meedu.member.invite.free_user_enabled' => 1]);
        $this->assertTrue($this->businessStatus->canGenerateInviteCode($user->toArray()));

        Auth::login($user);
        factory(PromoCode::class)->create([
            'user_id' => $user->id,
        ]);
        $this->assertFalse($this->businessStatus->canGenerateInviteCode($user->toArray()));
    }

    public function test_promoCodeCanUse_with_self()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $promoCode = factory(PromoCode::class)->create(['user_id' => $user->id]);
        $this->assertFalse($this->businessStatus->promoCodeCanUse($promoCode->toArray()));
    }

    public function test_promoCodeCanUse_with_used_times()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => $user->id + 1,
            'used_times' => 1,
            'use_times' => 1,
        ]);
        $this->assertFalse($this->businessStatus->promoCodeCanUse($promoCode->toArray()));
    }

    public function test_promoCodeCanUse_with_used()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => $user->id + 1,
        ]);
        factory(OrderPaidRecord::class)->create([
            'user_id' => $user->id,
            'paid_total' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
            'paid_type_id' => $promoCode->id,
        ]);
        $this->assertFalse($this->businessStatus->promoCodeCanUse($promoCode->toArray()));
    }

    public function test_promoCodeCanUse_with_invite_promo_code()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => $user->id + 1,
            'code' => 'U' . Str::random(),
        ]);
        $this->assertTrue($this->businessStatus->promoCodeCanUse($promoCode->toArray()));

        $user->is_used_promo_code = 1;
        $user->save();
        Auth::login($user);
        $this->assertFalse($this->businessStatus->promoCodeCanUse($promoCode->toArray()));
    }

    public function test_promoCodeCanUse_with_simple_promo_code()
    {
        $user = factory(User::class)->create([
            'is_used_promo_code' => 1,
        ]);
        Auth::login($user);
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => $user->id + 1,
            'code' => 'S' . Str::random(),
        ]);
        $this->assertTrue($this->businessStatus->promoCodeCanUse($promoCode->toArray()));
    }
}
