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
use App\Exceptions\ServiceException;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Course\Models\Video;
use App\Services\Course\Models\Course;
use App\Services\Order\Models\PromoCode;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserCourse;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\Member\Models\UserWatchStat;
use App\Services\Member\Services\UserService;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\UserServiceInterface;

class UserServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @var UserService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        $this->service = $this->app->make(UserServiceInterface::class);
    }

    public function test_findMobile()
    {
        $user = $this->service->findMobile('13000000000');
        $this->assertEmpty($user);
    }

    public function test_findMobile_with_mobile()
    {
        $user = factory(User::class)->create([
            'mobile' => '13090909090',
        ]);
        $u = $this->service->findMobile($user->mobile);
        $this->assertNotEmpty($u);
        $this->assertEquals($user->id, $u['id']);
    }

    public function test_resetPassword()
    {
        $this->expectException(ServiceException::class);

        $user = factory(User::class)->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        $this->service->resetPassword($user->id, '123123', '123123');
    }

    public function test_resetPassword_with_correct_old_password()
    {
        $user = factory(User::class)->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        $this->service->resetPassword($user->id, '123456', '123123');

        $user->refresh();
        $this->assertTrue(Hash::check('123123', $user->password));
    }

    public function test_findPassword()
    {
        $user = factory(User::class)->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        $this->service->findPassword($user->mobile, '123123');

        $user->refresh();
        $this->assertTrue(Hash::check('123123', $user->password));
    }

    public function test_createWithoutMobile()
    {
        $user = $this->service->createWithoutMobile('avatar', '我是meedu');
        $this->assertTrue(true);
    }

    public function test_createWithMobile()
    {
        $user = $this->service->createWithMobile('13909090909', 'avatar', '我是meedu');
        $this->assertTrue(true);
    }

    public function test_bindMobile()
    {
        $this->expectException(ServiceException::class);

        $user = factory(User::class)->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        Auth::login($user);
        $this->service->bindMobile('13909098080');
    }

    public function test_bindMobile_with_exists()
    {
        $this->expectException(ServiceException::class);

        factory(User::class)->create([
            'mobile' => '13909098080',
            'password' => Hash::make('123456'),
        ]);
        $user = factory(User::class)->create([
            'mobile' => '23090909090',
            'password' => Hash::make('123456'),
        ]);
        Auth::login($user);
        $this->service->bindMobile('13909098080');
    }

    public function test_bindMobile_with_need()
    {
        $user = factory(User::class)->create([
            'mobile' => '23090909090',
            'password' => Hash::make('123456'),
        ]);
        Auth::login($user);
        $this->service->bindMobile('13909098080');

        $oldMobile = $this->service->findMobile('23090909090');
        $newMobile = $this->service->findMobile('13909098080');

        $this->assertEmpty($oldMobile);
        $this->assertNotEmpty($newMobile);
    }

    public function test_bindMobile_with_exist_mobile()
    {
        $this->expectException(ServiceException::class);

        $user = factory(User::class)->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        $user2 = factory(User::class)->create([
            'mobile' => '13090909091',
            'password' => Hash::make('123456'),
        ]);
        Auth::login($user);
        $this->service->bindMobile($user2->mobile);
    }

    public function test_updateAvatar()
    {
        $user = factory(User::class)->create();
        $avatar = $this->faker->imageUrl();
        $this->service->updateAvatar($user->id, $avatar);
        $user->refresh();
        $this->assertEquals($avatar, $user->avatar);
    }

    public function test_getList()
    {
        $users = factory(User::class, 5)->create();
        $list = $this->service->getList([$users[0]->id, $users[1]->id]);
        $list = array_column($list, null, 'id');
        $this->assertNotEmpty($list);
        $this->assertTrue(isset($list[$users[1]->id]));
    }

    public function test_with()
    {
        $user = factory(User::class)->create();
        $u = $this->service->find($user->id, ['role']);
        $this->assertTrue(true);
    }

    public function test_messagePaginate()
    {
        $notificationService = $this->app->make(NotificationService::class);
        $user = factory(User::class)->create();
        Auth::login($user);
        $notificationService->notifyRegisterMessage($user->id);

        $page = $this->service->messagePaginate(1, 5);
        // todo 更详细的测试
        $this->assertEquals(1, $page['total']);
    }

    public function test_getUserBuyCourses()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        factory(UserCourse::class, 6)->create(['user_id' => $user->id]);
        $list = $this->service->getUserBuyCourses(1, 2);
        $this->assertEquals(6, $list['total']);
        $this->assertEquals(2, count($list['list']));
    }

    public function test_getUserBuyVideos()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        factory(UserVideo::class, 5)->create(['user_id' => $user->id]);
        $list = $this->service->getUserBuyVideos(2, 2);
        $this->assertEquals(5, $list['total']);
        $this->assertEquals(2, count($list['list']));
    }

    public function test_changeRole()
    {
        $user = factory(User::class)->create([
            'role_id' => 0,
        ]);
        Auth::login($user);

        $role = factory(Role::class)->create();

        $expiredAt = Carbon::now()->addDays($role->expire_days);
        $this->service->changeRole($user->id, $role->id, $expiredAt->toDateTimeString());

        $user->refresh();
        $this->assertEquals($role->id, $user->role_id);
        $this->assertEquals($expiredAt->toDateTimeString(), $user->role_expired_at);
    }

    public function test_hasCourse()
    {
        $user = factory(User::class)->create([
            'role_id' => 0,
        ]);
        $course = factory(Course::class)->create();

        $this->assertFalse($this->service->hasCourse($user->id, $course->id));

        factory(UserCourse::class)->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $this->assertTrue($this->service->hasCourse($user->id, $course->id));
    }

    public function test_hasVideo()
    {
        $user = factory(User::class)->create([
            'role_id' => 0,
        ]);
        $video = factory(Video::class)->create();

        $this->assertFalse($this->service->hasVideo($user->id, $video->id));

        factory(UserVideo::class)->create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);

        $this->assertTrue($this->service->hasVideo($user->id, $video->id));
    }

    public function test_findNickname()
    {
        factory(User::class)->create([
            'nick_name' => 'meedu',
        ]);
        $this->assertNotEmpty($this->service->findNickname('meedu'));
    }

    public function test_inviteUsers()
    {
        $user = factory(User::class)->create();
        Auth::login($user);
        factory(User::class, 9)->create([
            'invite_user_id' => $user->id,
        ]);
        $r = $this->service->inviteUsers(1, 5);
        $this->assertEquals(9, $r['total']);
    }

    public function test_updateInviteUserId()
    {
        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $promoCode = factory(PromoCode::class)->create([
            'user_id' => $user->id,
            'invite_user_reward' => 60,
            'invited_user_reward' => 12,
        ]);
        $this->service->updateInviteUserId($user1->id, $promoCode['user_id'], $promoCode['invite_user_reward']);

        $user->refresh();
        $this->assertEquals(60, $user->invite_balance);
        $user1->refresh();
        $this->assertEquals($user->id, $user1->invite_user_id);
    }

    public function test_getCurrentUserCourseCount()
    {
        config(['meedu.system.cache.status' => 1]);
        $user = factory(User::class)->create();
        factory(UserCourse::class, 10)->create(['user_id' => $user]);

        $this->assertEquals(10, $this->service->getUserCourseCount($user['id']));

        factory(UserCourse::class, 3)->create(['user_id' => $user]);
        $this->assertEquals(10, $this->service->getUserCourseCount($user['id']));
    }

    public function test_getCurrentUserVideoCount()
    {
        config(['meedu.system.cache.status' => 1]);
        $user = factory(User::class)->create();
        factory(UserVideo::class, 11)->create(['user_id' => $user]);

        $this->assertEquals(11, $this->service->getUserVideoCount($user['id']));

        factory(UserVideo::class, 5)->create(['user_id' => $user]);
        $this->assertEquals(11, $this->service->getUserVideoCount($user['id']));
    }

    public function test_inviteBalanceInc()
    {
        $user = factory(User::class)->create(['invite_balance' => 0]);
        $this->service->inviteBalanceInc($user['id'], 10);
        $user->refresh();
        $this->assertEquals(10, $user->invite_balance);

        $this->service->inviteBalanceInc($user['id'], -3);
        $user->refresh();
        $this->assertEquals(7, $user->invite_balance);
    }

    public function test_setUsedPromoCode()
    {
        $user = factory(User::class)->create(['is_used_promo_code' => 0]);
        $this->service->setUsedPromoCode($user->id);
        $user->refresh();
        $this->assertEquals(1, $user->is_used_promo_code);
    }

    public function test_changeMobile()
    {
        $user = factory(User::class)->create(['mobile' => '199000012341']);
        $this->service->changeMobile($user->id, '188999900011');
        $user->refresh();
        $this->assertEquals('188999900011', $user->mobile);
    }

    public function test_changeMobile_exists()
    {
        $this->expectException(ServiceException::class);

        $user = factory(User::class)->create(['mobile' => '199000012341']);
        $user = factory(User::class)->create(['mobile' => '13788889999']);
        $this->service->changeMobile($user->id, '13788889999');
    }

    public function test_watchStatSave()
    {
        $userId = 1;

        $this->service->watchStatSave($userId, 10);

        // 记录存在
        $record = UserWatchStat::query()->where('user_id', $userId)->first();
        $this->assertNotNull($record);
        $this->assertEquals(date('Y'), $record['year']);
        $this->assertEquals(date('m'), $record['month']);
        $this->assertEquals(date('d'), $record['day']);
        $this->assertEquals(10, $record['seconds']);


        $this->service->watchStatSave($userId, 22);
        $record->refresh();
        $this->assertEquals(32, $record['seconds']);
    }
}
