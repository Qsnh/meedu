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

use App\Constant\CacheConstant;
use Illuminate\Http\UploadedFile;
use App\Services\Member\Models\User;
use App\Services\Order\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\Order\Models\PromoCode;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserProfile;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Member\Models\UserCreditRecord;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Member\Models\UserInviteBalanceRecord;
use App\Services\Member\Models\UserInviteBalanceWithdrawOrder;
use App\Services\Member\Notifications\SimpleMessageNotification;

class MemberTest extends Base
{
    protected $member;

    public function setUp(): void
    {
        parent::setUp();
        $this->member = factory(User::class)->create();
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

    public function test_change_mobile()
    {
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put(get_cache_key(CacheConstant::MOBILE_CODE['name'], '17898765423'), 'code', 1);
        $response = $this->user($this->member)->postJson('api/v2/member/detail/mobile', [
            'mobile_code' => 'code',
            'mobile' => '17898765423',
        ]);
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertEquals('17898765423', $this->member->mobile);
    }

    public function test_change_mobile_exists()
    {
        factory(User::class)->create(['mobile' => '12345679876']);
        $cacheService = $this->app->make(CacheServiceInterface::class);
        $cacheService->put(get_cache_key(CacheConstant::MOBILE_CODE['name'], '12345679876'), 'code', 1);

        $response = $this->user($this->member)->postJson('api/v2/member/detail/mobile', [
            'mobile_code' => 'code',
            'mobile' => '12345679876',
        ]);
        $this->assertResponseError($response, __('mobile has exists'));
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
        $this->assertResponseError($response, __('current user cant set nickname'));
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
        $this->assertResponseError($response, __('file.max', ['size' => '1M']));
    }

    public function test_roles()
    {
        factory(UserJoinRoleRecord::class, 5)->create(['user_id' => $this->member->id]);
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
        factory(UserCourse::class, 4)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/courses');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(4, $response['data']['total']);
    }

    public function test_courses_like()
    {
        factory(UserLikeCourse::class, 6)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/courses/like');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(6, $response['data']['total']);
    }

    public function test_courses_history()
    {
        factory(CourseUserRecord::class, 5)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/courses/history');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(5, $response['data']['total']);
    }


    public function test_videos()
    {
        factory(UserVideo::class, 6)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/videos');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(6, $response['data']['total']);
    }

    public function test_orders()
    {
        factory(Order::class, 10)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/orders');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(10, $response['data']['total']);
    }

    public function test_inviteBalanceRecords()
    {
        factory(UserInviteBalanceRecord::class, 6)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/inviteBalanceRecords');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(6, $response['data']['total']);
    }

    public function test_promoCode()
    {
        $promoCode = factory(PromoCode::class)->create(['user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/promoCode');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals($promoCode->id, $response['data']['id']);
    }

    public function test_promoCode_post()
    {
        config(['meedu.member.invite.free_user_enabled' => 1]);
        $response = $this->user($this->member)->postJson('api/v2/member/promoCode');
        $response = $this->assertResponseSuccess($response);
        $this->assertNotEmpty(PromoCode::whereUserId($this->member->id)->first());
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

    public function test_inviteUsers()
    {
        factory(User::class, 10)->create(['invite_user_id' => $this->member->id]);
        $response = $this->user($this->member)->getJson('api/v2/member/inviteUsers?page=1&page_size=8');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(10, $response['data']['total']);
        $this->assertEquals(8, count($response['data']['data']));
    }

    public function test_withdrawRecords()
    {
        UserInviteBalanceWithdrawOrder::create([
            'user_id' => $this->member->id,
            'total' => 100,
            'channel' => '支付宝',
            'channel_name' => 'meedu',
            'channel_account' => 'meedu@meedu.vip',
            'channel_address' => 'address',
        ]);
        $response = $this->user($this->member)->getJson('api/v2/member/withdrawRecords?page=1&page_size=8');
        $response = $this->assertResponseSuccess($response);
        $this->assertEquals(1, $response['data']['total']);
        $this->assertEquals(1, count($response['data']['data']));
    }

    public function test_createWithdraw()
    {
        $this->member->invite_balance = 100;
        $this->member->save();

        $response = $this->user($this->member)->postJson('api/v2/member/withdraw', [
            'channel' => '支付宝',
            'channel_name' => 'meedu',
            'channel_account' => 'meedu1',
            'total' => 11,
        ]);
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertEquals(89, $this->member->invite_balance);

        $record = UserInviteBalanceWithdrawOrder::query()->where('user_id', $this->member->id)->first();
        $this->assertNotEmpty($record);
        $this->assertEquals('支付宝', $record->channel);
        $this->assertEquals('meedu', $record->channel_name);
        $this->assertEquals('meedu1', $record->channel_account);
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

    public function test_profile()
    {
        $response = $this->user($this->member)->getJson('api/v2/member/profile');
        $response = $this->assertResponseSuccess($response);
        $this->assertEmpty($response['data']);

        $profileData = [
            'user_id' => $this->member->id,
            'real_name' => 'meedu',
            'age' => 20,
            'birthday' => '20180610',
            'address' => '杭州西湖',
            'profession' => '开发',
            'graduated_school' => '嘟嘟嘟嘟',
            'id_number' => '1919828292',
        ];

        UserProfile::create($profileData);

        $response = $this->user($this->member)->getJson('api/v2/member/profile');
        $response = $this->assertResponseSuccess($response);
        $data = $response['data'];
        $this->assertEquals($profileData['real_name'], $data['real_name']);
        $this->assertEquals($profileData['age'], $data['age']);
        $this->assertEquals($profileData['birthday'], $data['birthday']);
        $this->assertEquals($profileData['address'], $data['address']);
        $this->assertEquals($profileData['profession'], $data['profession']);
        $this->assertEquals($profileData['graduated_school'], $data['graduated_school']);
        $this->assertEquals($profileData['id_number'], $data['id_number']);
    }

    public function test_profile_update()
    {
        $profileData = [
            'user_id' => $this->member->id,
            'real_name' => 'meedu',
            'age' => 20,
            'birthday' => '20180610',
            'address' => '杭州西湖',
            'profession' => '开发',
            'graduated_school' => '嘟嘟嘟嘟',
            'id_number' => '1919828292',
        ];
        $response = $this->user($this->member)->postJson('api/v2/member/profile', $profileData);
        $this->assertResponseSuccess($response);

        $data = UserProfile::query()->where('user_id', $this->member->id)->first();
        $this->assertEquals($profileData['real_name'], $data['real_name']);
        $this->assertEquals($profileData['age'], $data['age']);
        $this->assertEquals($profileData['birthday'], $data['birthday']);
        $this->assertEquals($profileData['address'], $data['address']);
        $this->assertEquals($profileData['profession'], $data['profession']);
        $this->assertEquals($profileData['graduated_school'], $data['graduated_school']);
        $this->assertEquals($profileData['id_number'], $data['id_number']);
    }

    public function test_profile_update_has_exists_profile()
    {
        UserProfile::create(['user_id' => $this->member->id]);

        $profileData = [
            'user_id' => $this->member->id,
            'real_name' => 'meedu',
            'age' => 20,
            'birthday' => '20180610',
            'address' => '杭州西湖',
            'profession' => '开发',
            'graduated_school' => '嘟嘟嘟嘟',
            'id_number' => '1919828292',
        ];
        $response = $this->user($this->member)->postJson('api/v2/member/profile', $profileData);
        $this->assertResponseSuccess($response);

        $data = UserProfile::query()->where('user_id', $this->member->id)->first();
        $this->assertEquals($profileData['real_name'], $data['real_name']);
        $this->assertEquals($profileData['age'], $data['age']);
        $this->assertEquals($profileData['birthday'], $data['birthday']);
        $this->assertEquals($profileData['address'], $data['address']);
        $this->assertEquals($profileData['profession'], $data['profession']);
        $this->assertEquals($profileData['graduated_school'], $data['graduated_school']);
        $this->assertEquals($profileData['id_number'], $data['id_number']);
    }
}
