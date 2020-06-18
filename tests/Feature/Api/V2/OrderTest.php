<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Api\V2;

use Carbon\Carbon;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Order\Models\PromoCode;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Order\Models\OrderPaidRecord;

class OrderTest extends Base
{
    public function test_createCourseOrder()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course->id,
            'promo_code' => 0,
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_createCourseOrder_with_0_charge()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'charge' => 0,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course->id,
            'promo_code' => 0,
        ]);
        $this->assertResponseError($response, __('course cant buy'));
    }

    public function test_createCourseOrder_with_purchased()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        UserCourse::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course->id,
            'promo_code' => 0,
        ]);
        $this->assertResponseError($response, __('course purchased'));
    }

    public function test_createCourseOrder_with_promo_code()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);

        $promoCode = factory(PromoCode::class)->create([
            'invited_user_reward' => 10,
            'code' => 'code1234',
            'expired_at' => Carbon::now()->addDays(1),
            'use_times' => 0,
        ]);

        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course->id,
            'promo_code' => $promoCode->code,
        ]);
        $order = $this->assertResponseSuccess($response);

        $this->assertEquals(10, OrderPaidRecord::whereOrderId($order['data']['id'])->sum('paid_total'));
    }

    public function test_createCourseOrder_with_promo_code_paid()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);

        $promoCode = factory(PromoCode::class)->create([
            'invited_user_reward' => 100,
            'code' => 'code1234',
            'expired_at' => Carbon::now()->addDays(1),
            'use_times' => 0,
        ]);

        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course->id,
            'promo_code' => $promoCode->code,
        ]);
        $order = $this->assertResponseSuccess($response);
        $this->assertEquals('已支付', $order['data']['status_text']);
    }

    public function test_createCourseOrder_with_promo_code_paid_second()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);

        $promoCode = factory(PromoCode::class)->create([
            'invited_user_reward' => 200,
            'code' => 'code1234',
            'expired_at' => Carbon::now()->addDays(1),
            'use_times' => 0,
        ]);

        $response = $this->user($user)->postJson('/api/v2/order/course', [
            'course_id' => $course->id,
            'promo_code' => $promoCode->code,
        ]);
        $order = $this->assertResponseSuccess($response);
        $this->assertEquals('已支付', $order['data']['status_text']);
    }

    public function test_createRoleOrder()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'charge' => 100,
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/role', [
            'role_id' => $role->id,
            'promo_code' => 0,
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_createRoleOrder_with_promo_code()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create([
            'charge' => 100,
            'is_show' => Course::SHOW_YES,
        ]);

        $promoCode = factory(PromoCode::class)->create([
            'invited_user_reward' => 10,
            'code' => 'code1234',
            'expired_at' => Carbon::now()->addDays(1),
            'use_times' => 0,
        ]);

        $response = $this->user($user)->postJson('/api/v2/order/role', [
            'role_id' => $role->id,
            'promo_code' => $promoCode->code,
        ]);
        $order = $this->assertResponseSuccess($response);

        $this->assertEquals(10, OrderPaidRecord::whereOrderId($order['data']['id'])->sum('paid_total'));
    }

    public function test_createVideoOrder()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/video', [
            'video_id' => $video->id,
            'promo_code' => 0,
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_createVideoOrder_with_0_charge()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'charge' => 0,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/video', [
            'video_id' => $video->id,
            'promo_code' => 0,
        ]);
        $this->assertResponseError($response, __('video cant buy'));
    }

    public function test_createVideoOrder_with_purchased()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        UserVideo::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/video', [
            'video_id' => $video->id,
            'promo_code' => 0,
        ]);
        $this->assertResponseError($response, __('video purchased'));
    }

    public function test_createVideoOrder_with_promo_code()
    {
        $user = factory(User::class)->create();
        $video = factory(Video::class)->create([
            'charge' => 100,
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => Course::SHOW_YES,
        ]);
        $promoCode = factory(PromoCode::class)->create([
            'invited_user_reward' => 10,
            'code' => 'code1234',
            'expired_at' => Carbon::now()->addDays(1),
            'use_times' => 0,
        ]);
        $response = $this->user($user)->postJson('/api/v2/order/video', [
            'video_id' => $video->id,
            'promo_code' => $promoCode->code,
        ]);
        $order = $this->assertResponseSuccess($response);

        $this->assertEquals(10, OrderPaidRecord::whereOrderId($order['data']['id'])->sum('paid_total'));
    }
}
