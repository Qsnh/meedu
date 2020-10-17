<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Tests\Feature\Page;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Events\UserLoginEvent;
use App\Constant\CacheConstant;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Course\Models\Video;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use App\Services\Course\Models\Course;
use App\Services\Order\Models\PromoCode;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserWatchStat;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Member\Models\UserVideoWatchRecord;

class AjaxTest extends TestCase
{
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create([
            'credit1' => 0,
        ]);
    }

    public function tearDown(): void
    {
        $this->user->delete();
        parent::tearDown();
    }

    public function test_course_comment_with_empty_content()
    {
        $course = factory(Course::class)->create([
            'published_at' => Carbon::now()->subDays(1),
            'is_show' => 1,
        ]);
        $this->actingAs($this->user)->post('/member/ajax/course/' . $course->id . '/comment', [
            'content' => '',
        ])->seeStatusCode(302);
        $this->assertEquals(__('comment.content.required'), get_first_flash('warning'));
    }

    public function test_course_comment_with_min_length()
    {
        $course = factory(Course::class)->create();
        $this->actingAs($this->user)->post('/member/ajax/course/' . $course->id . '/comment', [
            'content' => '12345',
        ])->seeStatusCode(302);
        $this->assertEquals(__('comment.content.min', ['count' => 6]), get_first_flash('warning'));
    }

    public function test_course_comment()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Course::COMMENT_STATUS_ALL,
        ]);
        $this->actingAs($this->user)->post('/member/ajax/course/' . $course->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->seeStatusCode(200);
    }

    public function test_course_comment_close()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Course::COMMENT_STATUS_CLOSE,
        ]);
        $response = $this->actingAs($this->user)->post('/member/ajax/course/' . $course->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(1, $response['code']);
        $this->assertEquals(__('course cant comment'), $response['message']);
    }

    public function test_course_comment_only_vip()
    {
        $role = factory(Role::class)->create();
        $this->user->role_id = $role->id;
        $this->user->role_expired_at = Carbon::now()->addDays(1);
        $this->user->save();

        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Course::COMMENT_STATUS_ONLY_PAID,
        ]);
        $response = $this->actingAs($this->user)->post('/member/ajax/course/' . $course->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(0, $response['code']);
    }

    public function test_course_comment_only_paid_course()
    {
        $course = factory(Course::class)->create([
            'is_show' => Course::SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Course::COMMENT_STATUS_ONLY_PAID,
        ]);

        UserCourse::create([
            'user_id' => $this->user->id,
            'course_id' => $course->id,
        ]);

        $response = $this->actingAs($this->user)->post('/member/ajax/course/' . $course->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(0, $response['code']);
    }

    public function test_video_comment()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
        ]);
        $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->seeStatusCode(200);
    }

    public function test_video_comment_close()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_CLOSE,
        ]);
        $response = $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(1, $response['code']);
        $this->assertEquals(__('video cant comment'), $response['message']);
    }

    public function test_video_comment_close_and_vip()
    {
        $role = factory(Role::class)->create();
        $this->user->role_id = $role->id;
        $this->user->role_expired_at = Carbon::now()->addDays(1);
        $this->user->save();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_CLOSE,
        ]);
        $response = $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(1, $response['code']);
        $this->assertEquals(__('video cant comment'), $response['message']);
    }

    public function test_video_comment_only_paid()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);
        $response = $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(1, $response['code']);
        $this->assertEquals(__('video cant comment'), $response['message']);
    }

    public function test_video_comment_only_paid_for_vip()
    {
        $role = factory(Role::class)->create();
        $this->user->role_id = $role->id;
        $this->user->role_expired_at = Carbon::now()->addDays(1);
        $this->user->save();

        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);
        $response = $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(0, $response['code']);
    }

    public function test_video_comment_only_paid_for_free()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 0,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);
        $response = $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(0, $response['code']);
    }

    public function test_video_comment_only_paid_for_buy()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);

        UserVideo::create(['video_id' => $video->id, 'user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(0, $response['code']);
    }

    public function test_video_comment_only_paid_for_buy_course()
    {
        $video = factory(Video::class)->create([
            'is_show' => Video::IS_SHOW_YES,
            'charge' => 1,
            'published_at' => Carbon::now()->subDays(1),
            'comment_status' => Video::COMMENT_STATUS_ONLY_PAID,
        ]);

        UserCourse::create(['course_id' => $video->course_id, 'user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->decodeResponseJson();
        $this->assertEquals(0, $response['code']);
    }

    // 不存在的优惠码
    public function test_promoCodeCheck_with_not_exists_promo_code()
    {
        $promoCode = factory(PromoCode::class)->create([
            'invite_user_reward' => 10,
            'invited_user_reward' => 10,
            'use_times' => 1,
            'used_times' => 0,
        ]);

        $response = $this->actingAs($this->user)->post('/member/ajax/promoCodeCheck', [
            'promo_code' => Str::random(6),
        ])->seeStatusCode(200)->response;
        $this->assertResponseError($response, __('promo code not exists'));
    }

    // 过期的优惠码无法使用
    public function test_promoCodeCheck_with_expired_promo_code()
    {
        $promoCode = factory(PromoCode::class)->create([
            'invite_user_reward' => 10,
            'invited_user_reward' => 10,
            'use_times' => 1,
            'used_times' => 0,
            'expired_at' => Carbon::now()->subDays(1),
        ]);

        $response = $this->actingAs($this->user)->post('/member/ajax/promoCodeCheck', [
            'promo_code' => $promoCode->code,
        ])->seeStatusCode(200)->response;
        $this->assertResponseError($response, __('promo code has expired'));
    }

    // 优惠码使用次数用完了
    public function test_promoCodeCheck_with_use_times_out()
    {
        $promoCode = factory(PromoCode::class)->create([
            'invite_user_reward' => 10,
            'invited_user_reward' => 10,
            'use_times' => 1,
            'used_times' => 1,
        ]);

        $response = $this->actingAs($this->user)->post('/member/ajax/promoCodeCheck', [
            'promo_code' => $promoCode->code,
        ])->seeStatusCode(200)->response;
        $this->assertResponseError($response, __('user cant use this promo code'));
    }

    // 自己的优惠码无法使用
    public function test_promoCodeCheck_with_self_code()
    {
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => $this->user->id,
            'invite_user_reward' => 10,
            'invited_user_reward' => 10,
            'use_times' => 1,
            'used_times' => 0,
        ]);

        $response = $this->actingAs($this->user)->post('/member/ajax/promoCodeCheck', [
            'promo_code' => $promoCode->code,
        ])->seeStatusCode(200)->response;
        $this->assertResponseError($response, __('user cant use this promo code'));
    }

    // 已使用过该优惠码
    public function test_promoCodeCheck_with_used_code()
    {
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => 0,
            'invite_user_reward' => 10,
            'invited_user_reward' => 10,
            'use_times' => 1,
            'used_times' => 0,
        ]);

        OrderPaidRecord::create([
            'user_id' => $this->user->id,
            'order_id' => 0,
            'paid_total' => 1,
            'paid_type' => OrderPaidRecord::PAID_TYPE_PROMO_CODE,
            'paid_type_id' => $promoCode->id,
        ]);

        $response = $this->actingAs($this->user)->post('/member/ajax/promoCodeCheck', [
            'promo_code' => $promoCode->code,
        ])->seeStatusCode(200)->response;
        $this->assertResponseError($response, __('user cant use this promo code'));
    }

    public function test_promoCodeCheck()
    {
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => 0,
            'invite_user_reward' => 10,
            'invited_user_reward' => 10,
            'use_times' => 1,
            'used_times' => 0,
        ]);

        $response = $this->actingAs($this->user)->post('/member/ajax/promoCodeCheck', [
            'promo_code' => $promoCode->code,
        ])->seeStatusCode(200)->response;
        $this->assertResponseAjaxSuccess($response);
    }

    public function test_changePassword()
    {
        $this->user->password = Hash::make('123123');
        $this->user->save();

        $this->actingAs($this->user)->post('/member/ajax/password/change', [
            'new_password' => '123456',
            'new_password_confirmation' => '123456',
            'old_password' => '123123',
        ])->seeStatusCode(200);
    }

    public function test_changePassword_with_not_correct_password()
    {
        $this->user->password = Hash::make('123123');
        $this->user->save();

        $this->actingAs($this->user)->post('/member/ajax/password/change', [
            'new_password' => '123456',
            'new_password_confirmation' => '123456',
            'old_password' => '123456',
        ])->response;
        $this->assertEquals(__('old_password_error'), get_first_flash('warning'));
    }

    public function test_changePassword_with_first_reset_password()
    {
        $this->user->is_password_set = 0;
        $this->user->save();

        $this->actingAs($this->user)->post('/member/ajax/password/change', [
            'new_password' => '123456',
            'new_password_confirmation' => '123456',
        ])->seeStatusCode(200);

        $this->user->refresh();
        $this->assertTrue(Hash::check('123456', $this->user->password));
    }

    //    public function test_avatarChange()
    //    {
    //        Storage::fake('mock');
    //        config(['meedu.upload.image.disk' => 'mock']);
    //        $this->actingAs($this->user)->post('/member/ajax/avatar/change', [
    //            'file' => UploadedFile::fake()->image('file.png'),
    //        ])->seeStatusCode(200);
    //    }

    public function test_nicknameChange()
    {
        $this->actingAs($this->user)->post('/member/ajax/nickname/change', [
            'nick_name' => 'meedu123',
        ])->seeStatusCode(200);

        $this->user->refresh();
        $this->assertEquals('meedu123', $this->user->nick_name);
    }

    public function test_nicknameChange_already_set()
    {
        $this->user->is_set_nickname = 1;
        $this->user->save();

        $this->actingAs($this->user)->post('/member/ajax/nickname/change', [
            'nick_name' => 'meedu123',
        ]);
        $this->assertEquals(__('current user cant set nickname'), get_first_flash('warning'));
    }

    public function test_nicknameChange_repeat()
    {
        factory(User::class)->create(['nick_name' => 'meedu123']);

        $this->actingAs($this->user)->post('/member/ajax/nickname/change', [
            'nick_name' => 'meedu123',
        ]);
        $this->assertEquals(__('nick_name.unique'), get_first_flash('warning'));
    }

    public function test_inviteBalanceWithdraw_insufficient()
    {
        $response = $this->actingAs($this->user)->post('/member/ajax/inviteBalanceWithdraw', [
            'total' => 100,
            'channel' => [
                'name' => '姓名',
                'account' => '账号',
                'username' => '账号名',
            ]
        ])->response;
        $this->assertResponseError($response, __('Insufficient invite balance'));
    }

    public function test_inviteBalanceWithdraw()
    {
        $this->user->invite_balance = 100;
        $this->user->save();

        $response = $this->actingAs($this->user)->post('/member/ajax/inviteBalanceWithdraw', [
            'total' => 100,
            'channel' => [
                'name' => '姓名',
                'account' => '账号',
                'username' => '账号名',
            ]
        ])->response;
        $this->assertResponseAjaxSuccess($response);

        $this->user->refresh();
        $this->assertEquals(0, $this->user->invite_balance);
    }

    public function test_courseLike()
    {
        $course = factory(Course::class)->create();
        $this->actingAs($this->user)->post('/member/ajax/course/like/' . $course->id)->seeStatusCode(200);

        $this->assertTrue(UserLikeCourse::whereUserId($this->user->id)->whereCourseId($course->id)->exists());
    }

    public function test_passwordLogin_with_not_correct_password()
    {
        $this->user->password = Hash::make('12313');
        $this->user->save();


        $response = $this->post('/ajax/auth/login/password', [
            'mobile' => $this->user->mobile,
            'password' => '123456',
        ])->seeStatusCode(200)->response;
        $this->assertResponseError($response, __('mobile not exists or password error'));
    }

    public function test_passwordLogin_with_lock()
    {
        $this->user->is_lock = 1;
        $this->user->password = Hash::make('123123');
        $this->user->save();


        $response = $this->post('/ajax/auth/login/password', [
            'mobile' => $this->user->mobile,
            'password' => '123123',
        ])->seeStatusCode(200)->response;
        $this->assertResponseError($response, __('current user was locked,please contact administrator'));
    }

    public function test_passwordLogin()
    {
        Event::fake();

        $this->user->is_lock = 0;
        $this->user->password = Hash::make('123123');
        $this->user->save();


        $response = $this->post('/ajax/auth/login/password', [
            'mobile' => $this->user->mobile,
            'password' => '123123',
        ])->seeStatusCode(200)->response;
        $this->assertResponseAjaxSuccess($response);

        // 触发了登录事件
        Event::assertDispatched(UserLoginEvent::class);
    }

    public function test_mobileLogin_with_not_correct_sms()
    {
        session(['sms_mock' => 'mock']);
        $this->post('/ajax/auth/login/mobile', [
            'mobile' => '13900000000',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock123',
        ])->seeStatusCode(302);
        $this->assertEquals(__('mobile code error'), get_first_flash('warning'));
    }

    public function test_mobileLogin_with_mobile_not_exists()
    {
        session(['sms_mock' => 'mock']);
        $this->post('/ajax/auth/login/mobile', [
            'mobile' => '13900000000',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->seeStatusCode(200);

        // 创建了用户
        $user = User::query()->where('mobile', '13900000000')->first();
        $this->assertNotNull($user);
        $this->assertEquals(0, $user->is_set_nickname);
        $this->assertEquals(0, $user->is_password_set);
    }

    public function test_mobileLogin_with_mobile_exists()
    {
        session(['sms_mock' => 'mock']);
        $this->post('/ajax/auth/login/mobile', [
            'mobile' => $this->user->mobile,
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->seeStatusCode(200);
    }

    public function test_mobileLogin_with_user_lock()
    {
        $this->user->is_lock = 1;
        $this->user->save();

        session(['sms_mock' => 'mock']);
        $this->post('/ajax/auth/login/mobile', [
            'mobile' => $this->user->mobile,
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->seeStatusCode(200);
    }

    public function test_register()
    {
        session(['sms_mock' => 'mock']);
        $this->post('/ajax/auth/register', [
            'mobile' => '13988889999',
            'password' => '123123',
            'password_confirmation' => '123123',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->seeStatusCode(200);

        $user = User::query()->where('mobile', '13988889999')->first();
        $this->assertNotNull($user);
        $this->assertEquals(0, $user->is_set_nickname);
        $this->assertEquals(1, $user->is_password_set);
    }

    public function test_register_with_exists_mobile()
    {
        session(['sms_mock' => 'mock']);
        $response = $this->post('/ajax/auth/register', [
            'nick_name' => Str::random(6),
            'mobile' => $this->user->mobile,
            'password' => '123123',
            'password_confirmation' => '123123',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->response;
        $this->assertResponseError($response, __('mobile.unique'));
    }

    public function test_register_with_exists_nickname()
    {
        $this->user->nick_name = '我是昵称';
        $this->user->save();

        session(['sms_mock' => 'mock']);
        $response = $this->post('/ajax/auth/register', [
            'nick_name' => '我是昵称',
            'mobile' => '13877779999',
            'password' => '123123',
            'password_confirmation' => '123123',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->response;
        $this->assertResponseError($response, __('nick_name.unique'));
    }

    public function test_passwordReset()
    {
        $this->user->password = Hash::make('123456');
        $this->user->save();

        session(['sms_mock' => 'mock']);
        $response = $this->post('/ajax/auth/password/reset', [
            'mobile' => $this->user->mobile,
            'password' => '123123',
            'password_confirmation' => '123123',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->response;
        $this->assertResponseAjaxSuccess($response);

        $this->user->refresh();
        $this->assertTrue(Hash::check('123123', $this->user->password));
    }

    public function test_mobileBind()
    {
        $this->user->mobile = '234567';
        $this->user->save();

        session(['sms_mock' => 'mock']);
        $response = $this->actingAs($this->user)->post('/ajax/auth/mobile/bind', [
            'mobile' => '13899990000',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->response;
        $this->assertResponseAjaxSuccess($response);

        $this->user->refresh();
        $this->assertEquals('13899990000', $this->user->mobile);
    }

    public function test_mobileBind_with_binded()
    {
        $this->user->mobile = '13899990001';
        $this->user->save();

        session(['sms_mock' => 'mock']);
        $this->actingAs($this->user)->post('/ajax/auth/mobile/bind', [
            'mobile' => '13899990000',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->seeStatusCode(302);
        $this->assertEquals(__('cant bind mobile'), get_first_flash('warning'));
    }

    public function test_mobileBind_with_mobile_exsits()
    {
        $this->user->mobile = '3434';
        $this->user->save();

        factory(User::class)->create(['mobile' => '13666667777']);

        session(['sms_mock' => 'mock']);
        $this->actingAs($this->user)->post('/ajax/auth/mobile/bind', [
            'mobile' => '13666667777',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->seeStatusCode(302);
        $this->assertEquals(__('mobile has exists'), get_first_flash('warning'));
    }

    public function test_user_video_watch_record()
    {
        // 看完奖励2积分
        config(['meedu.member.credit1.watched_video' => 2]);
        config(['meedu.member.credit1.watched_course' => 3]);

        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'duration' => 100,
            'charge' => 0,
        ]);
        $video1 = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'duration' => 90,
            'charge' => 0,
        ]);

        //------- 第一步，两个视频分别看5s,10s
        $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/watch/record', [
            'duration' => 5,
        ])->seeStatusCode(200);
        $this->actingAs($this->user)->post('/member/ajax/video/' . $video1->id . '/watch/record', [
            'duration' => 10,
        ])->seeStatusCode(200);

        $record = UserVideoWatchRecord::query()->where('user_id', $this->user->id)->where('video_id', $video->id)->first();
        $this->assertNotEmpty($record);
        $this->assertEquals(5, $record->watch_seconds);
        $record1 = UserVideoWatchRecord::query()->where('user_id', $this->user->id)->where('video_id', $video1->id)->first();
        $this->assertNotEmpty($record1);
        $this->assertEquals(10, $record1->watch_seconds);

        $courseUser = CourseUserRecord::create([
            'user_id' => $this->user->id,
            'course_id' => $video->course_id,
        ]);

        //------- 第二步，第一个视频看100s(也就是看完)；第二个视频看50s(未看完:90s)
        $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/watch/record', [
            'duration' => 100,
        ])->seeStatusCode(200);
        $this->actingAs($this->user)->post('/member/ajax/video/' . $video1->id . '/watch/record', [
            'duration' => 50,
        ])->seeStatusCode(200);

        // 第一个视频看完
        $record->refresh();
        $this->assertEquals(100, $record->watch_seconds);
        $this->assertNotEmpty($record->watched_at);
        $record1->refresh();
        $this->assertEquals(50, $record1->watch_seconds);
        $this->assertEmpty($record1->watched_at);

        // 第一个视频看完积分到账
        $this->user->refresh();
        $this->assertEquals(2, $this->user->credit1);

        // 观看进度达到50%
        // 因为该课程下有两个视频
        // 看完了一个视频，进度=50%
        $courseUser->refresh();
        $this->assertEquals(0, $courseUser->is_watched);
        $this->assertNull($courseUser->watched_at);
        $this->assertEquals(50, $courseUser->progress);

        $this->actingAs($this->user)->post('/member/ajax/video/' . $video1->id . '/watch/record', [
            'duration' => 80,
        ])->seeStatusCode(200);

        $courseUser->refresh();
        // 第二个视频依旧没看完
        // 第二个视频没有看完，依旧是50
        $this->assertEquals(0, $courseUser->is_watched);
        $this->assertNull($courseUser->watched_at);
        $this->assertEquals(50, $courseUser->progress);

        $this->actingAs($this->user)->post('/member/ajax/video/' . $video1->id . '/watch/record', [
            'duration' => 90,
        ])->seeStatusCode(200);

        $courseUser->refresh();
        // 第二个视频也看完了，课程进度也变为100
        $this->assertEquals(1, $courseUser->is_watched);
        $this->assertNotNull($courseUser->watched_at);
        $this->assertEquals(100, $courseUser->progress);

        // 课程全部看完，积分到账3积分
        // 前面看完了2个视频奖励工奖励4分+课程完成3分=7分
        $this->user->refresh();
        $this->assertEquals(7, $this->user->credit1);
    }

    public function test_user_video_watch_record_after_user_watch_stat()
    {
        $course = factory(Course::class)->create();
        $video = factory(Video::class)->create([
            'course_id' => $course->id,
            'is_show' => Video::IS_SHOW_YES,
            'published_at' => Carbon::now()->subDays(1),
            'duration' => 100,
            'charge' => 0,
        ]);

        // 前置判断
        $this->assertFalse(UserWatchStat::query()->where('user_id', $this->user['id'])->exists());

        // 前置环境
        $cacheKey = sprintf(CacheConstant::USER_VIDEO_WATCH_DURATION['name'], $video['id']);
        Cache::put($cacheKey, 1, 10);

        // 观看10秒
        $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/watch/record', [
            'duration' => 10,
        ])->seeStatusCode(200);


        $record = UserWatchStat::query()->where('user_id', $this->user['id'])->first();
        $this->assertNotNull($record);
        $this->assertEquals(date('Y'), $record['year']);
        $this->assertEquals(date('m'), $record['month']);
        $this->assertEquals(date('d'), $record['day']);
        $this->assertEquals(9, $record['seconds']);

        // 继续观看
        $this->actingAs($this->user)->post('/member/ajax/video/' . $video->id . '/watch/record', [
            'duration' => 29,
        ])->seeStatusCode(200);

        $record->refresh();
        $this->assertEquals(28, $record['seconds']);

        // 清空前置配置
        Cache::forget($cacheKey);
    }
}
