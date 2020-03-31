<?php


namespace Tests\Feature\Page;


use App\Services\Course\Models\Course;
use App\Services\Course\Models\Video;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Order\Models\OrderPaidRecord;
use App\Services\Order\Models\PromoCode;
use Carbon\Carbon;
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

}