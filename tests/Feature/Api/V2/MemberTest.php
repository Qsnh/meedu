<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Feature\Api\V2;

use App\Meedu\Verify;
use App\Constant\CacheConstant;
use Illuminate\Http\UploadedFile;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Member\Models\UserCreditRecord;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Member\Notifications\SimpleMessageNotification;

class MemberTest extends Base
{
    protected $member;

    public function setUp(): void
    {
        parent::setUp();
        $this->member = User::factory()->create();
    }

    public function test_detail()
    {
        $response = $this->user($this->member)->getJson('api/v2/member/detail');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals($this->member->id, $response['data']['id']);
        $this->assertEquals($this->member->nick_name, $response['data']['nick_name']);
    }

    public function test_password()
    {
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put(get_cache_key(CacheConstant::MOBILE_CODE['name'], $this->member->mobile), 'code', 1);
        $response = $this->user($this->member)->postJson('api/v2/member/detail/password', [
            'mobile_code' => 'code',
            'mobile' => $this->member->mobile,
            'password' => '123123',
        ]);
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertTrue(Hash::check('123123', $this->member->password));
    }

    public function test_mobile_bind()
    {
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put(get_cache_key(CacheConstant::MOBILE_CODE['name'], '17898765423'), 'code', 1);

        $sign = $this->app->make(Verify::class)->gen();

        // 必须是未绑定的手机号才能绑定
        $this->member->mobile = '27898765423';
        $this->member->save();

        $response = $this->user($this->member)->postJson('api/v2/member/detail/mobile', [
            'mobile_code' => 'code',
            'mobile' => '17898765423',
            'sign' => $sign,
        ]);
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertEquals('17898765423', $this->member->mobile);
    }

    public function test_mobile_bind_has_binded()
    {
        User::factory()->create(['mobile' => '12345679876']);
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put(get_cache_key(CacheConstant::MOBILE_CODE['name'], '12345679876'), 'code', 1);

        $sign = $this->app->make(Verify::class)->gen();

        // 必须是未绑定的手机号才能绑定
        $this->member->mobile = '17898765128';
        $this->member->save();

        $response = $this->user($this->member)->postJson('api/v2/member/detail/mobile', [
            'mobile_code' => 'code',
            'mobile' => '12345679876',
            'sign' => $sign,
        ]);
        $this->assertResponseError($response, __('已绑定'));
    }

    public function test_mobile_bind_mobile_exists()
    {
        User::factory()->create(['mobile' => '12345679876']);
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put(get_cache_key(CacheConstant::MOBILE_CODE['name'], '12345679876'), 'code', 1);

        $sign = $this->app->make(Verify::class)->gen();

        // 必须是未绑定的手机号才能绑定
        $this->member->mobile = '27898765423';
        $this->member->save();

        $response = $this->user($this->member)->postJson('api/v2/member/detail/mobile', [
            'mobile_code' => 'code',
            'mobile' => '12345679876',
            'sign' => $sign,
        ]);
        $this->assertResponseError($response, __('手机号已存在'));
    }

    public function test_nickname()
    {
        $response = $this->user($this->member)->postJson('api/v2/member/detail/nickname', [
            'nick_name' => 'nick1',
        ]);
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertEquals('nick1', $this->member->nick_name);
    }

    public function test_nickname_already_set()
    {
        // 已设置过昵称
        $this->member->is_set_nickname = 1;
        $this->member->save();


        $response = $this->user($this->member)->postJson('api/v2/member/detail/nickname', [
            'nick_name' => 'nick1',
        ]);
        $this->assertResponseError($response, __('当前用户已配置昵称'));
    }

    public function test_avatar()
    {
        Storage::fake('public');
        $response = $this->user($this->member)->postJson('api/v2/member/detail/avatar', [
            'file' => UploadedFile::fake()->image('avatar.jpg')->size(256),
        ]);
        $this->assertResponseSuccess($response);
    }

    public function test_avatar_size()
    {
        Storage::fake('public');
        $response = $this->user($this->member)->postJson('api/v2/member/detail/avatar', [
            'file' => UploadedFile::fake()->image('avatar.jpg')->size(1025),
        ]);
        $this->assertResponseError($response, __('文件不能超过:size', ['size' => '1M']));
    }

    public function test_roles()
    {
        UserJoinRoleRecord::factory()->count(5)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/roles');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(5, $response['data']['total']);
    }

    public function test_messages()
    {
        $response = $this->user($this->member)->getJson('api/v2/member/messages');
        $response = $this->assertResponseSuccess($response);
    }

    public function test_courses()
    {
        UserCourse::factory()->count(4)->create([
            'user_id' => $this->member->id,
        ]);
        $response = $this->user($this->member)->getJson('api/v2/member/courses');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(4, $response['data']['total']);
    }

    public function test_courses_like()
    {
        UserLikeCourse::factory()->count(6)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/courses/like');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(6, $response['data']['total']);
    }

    public function test_courses_history()
    {
        CourseUserRecord::factory()->count(5)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/courses/history');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(5, $response['data']['total']);
    }

    public function test_videos()
    {
        UserVideo::factory()->count(6)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/videos');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(6, $response['data']['total']);
    }

    public function test_orders()
    {
        Order::factory()->count(10)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/orders');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(10, $response['data']['total']);
    }

    public function test_messages_markAsRead()
    {
        $this->member->notify(new SimpleMessageNotification('meedu消息测试'));
        $this->assertEquals(1, $this->member->unreadNotifications->count());

        $notification = $this->member->unreadNotifications->first();
        $response = $this->user($this->member)->getJson('api/v2/member/notificationMarkAsRead/' . $notification->id);
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertEquals(0, $this->member->unreadNotifications->count());
    }

    public function test_messages_markAsAllRead()
    {
        $this->member->notify(new SimpleMessageNotification('meedu消息测试1'));
        $this->member->notify(new SimpleMessageNotification('meedu消息测试2'));
        $this->member->notify(new SimpleMessageNotification('meedu消息测试3'));
        $this->assertEquals(3, $this->member->unreadNotifications->count());

        $response = $this->user($this->member)->getJson('api/v2/member/notificationMarkAllAsRead');
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertEquals(0, $this->member->unreadNotifications->count());
    }

    public function test_messages_unreadNotificationCount()
    {
        $this->member->notify(new SimpleMessageNotification('meedu消息测试1'));
        $this->member->notify(new SimpleMessageNotification('meedu消息测试2'));

        $response = $this->user($this->member)->getJson('api/v2/member/unreadNotificationCount');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(2, $response['data']);

        $this->member->notify(new SimpleMessageNotification('meedu消息测试2'));

        $response = $this->user($this->member)->getJson('api/v2/member/unreadNotificationCount');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(3, $response['data']);
    }

    public function test_credit1Records()
    {
        UserCreditRecord::create([
            'field' => 'credit1',
            'user_id' => $this->member->id,
            'sum' => 101,
            'remark' => 'meedu test1'
        ]);
        UserCreditRecord::create([
            'field' => 'credit1',
            'user_id' => $this->member->id,
            'sum' => 102,
            'remark' => 'meedu test2'
        ]);
        UserCreditRecord::create([
            'field' => 'credit1',
            'user_id' => $this->member->id,
            'sum' => 103,
            'remark' => 'meedu test3'
        ]);
        $response = $this->user($this->member)->getJson('api/v2/member/credit1Records?page=1&page_size=8');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(3, $response['data']['total']);
        $this->assertEquals(3, count($response['data']['data']));

        $response = $this->user($this->member)->getJson('api/v2/member/credit1Records?page=2&page_size=8');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(3, $response['data']['total']);
        $this->assertEquals(0, count($response['data']['data']));
    }
}
