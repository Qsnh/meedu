<?php


namespace Tests\Feature\Page;


use App\Events\UserLoginEvent;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\Video;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Order\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AjaxTest extends TestCase
{

    protected $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function tearDown()
    {
        $this->user->delete();
        parent::tearDown();
    }

    public function test_course_comment_with_empty_content()
    {
        $course = factory(Course::class)->create();
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
        ]);
        $this->actingAs($this->user)->post('/member/ajax/course/' . $course->id . '/comment', [
            'content' => '哈哈哈哈，我要评论下',
        ])->seeStatusCode(200);
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
        $this->assertTrue(User::whereMobile('13900000000')->exists());
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
            'nick_name' => Str::random(6),
            'mobile' => '13988889999',
            'password' => '123123',
            'password_confirmation' => '123123',
            'sms_captcha_key' => 'mock',
            'sms_captcha' => 'mock',
        ])->seeStatusCode(200);

        $this->assertTrue(User::whereMobile('13988889999')->exists());
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

}