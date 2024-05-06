<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
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
        $user = User::factory()->create([
            'mobile' => '13090909090',
        ]);
        $u = $this->service->findMobile($user->mobile);
        $this->assertNotEmpty($u);
        $this->assertEquals($user->id, $u['id']);
    }

    public function test_resetPassword()
    {
        $this->expectException(ServiceException::class);

        $user = User::factory()->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        $this->service->resetPassword($user->id, '123123', '123123');
    }

    public function test_resetPassword_with_correct_old_password()
    {
        $user = User::factory()->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        $this->service->resetPassword($user->id, '123456', '123123');

        $user->refresh();
        $this->assertTrue(Hash::check('123123', $user->password));
    }

    public function test_findPassword()
    {
        $user = User::factory()->create([
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

        $user = User::factory()->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        $this->service->bindMobile('13909098080', $user['id']);
    }

    public function test_bindMobile_with_exists()
    {
        $this->expectException(ServiceException::class);

        User::factory()->create([
            'mobile' => '13909098080',
            'password' => Hash::make('123456'),
        ]);
        $user = User::factory()->create([
            'mobile' => '23090909090',
            'password' => Hash::make('123456'),
        ]);

        $this->service->bindMobile('13909098080', $user['id']);
    }

    public function test_bindMobile_with_need()
    {
        $user = User::factory()->create([
            'mobile' => '23090909090',
            'password' => Hash::make('123456'),
        ]);

        $this->service->bindMobile('13909098080', $user['id']);

        $oldMobile = $this->service->findMobile('23090909090');
        $newMobile = $this->service->findMobile('13909098080');

        $this->assertEmpty($oldMobile);
        $this->assertNotEmpty($newMobile);
    }

    public function test_bindMobile_with_exist_mobile()
    {
        $this->expectException(ServiceException::class);

        $user = User::factory()->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);

        $user2 = User::factory()->create([
            'mobile' => '13090909091',
            'password' => Hash::make('123456'),
        ]);

        $this->service->bindMobile($user2->mobile, $user['id']);
    }

    public function test_updateAvatar()
    {
        $user = User::factory()->create();
        $avatar = $this->faker->imageUrl();
        $this->service->updateAvatar($user->id, $avatar);
        $user->refresh();
        $this->assertEquals($avatar, $user->avatar);
    }

    public function test_getList()
    {
        $users = User::factory()->count(5)->create();
        $list = $this->service->getList([$users[0]->id, $users[1]->id]);
        $list = array_column($list, null, 'id');
        $this->assertNotEmpty($list);
        $this->assertTrue(isset($list[$users[1]->id]));
    }

    public function test_with()
    {
        $user = User::factory()->create();
        $u = $this->service->find($user->id, ['role']);
        $this->assertTrue(true);
    }

    public function test_messagePaginate()
    {
        $notificationService = $this->app->make(NotificationService::class);
        $user = User::factory()->create();
        Auth::login($user);
        $notificationService->notifyRegisterMessage($user->id);

        $page = $this->service->messagePaginate(1, 5);
        // todo 更详细的测试
        $this->assertEquals(1, $page['total']);
    }

    public function test_getUserBuyCourses()
    {
        $user = User::factory()->create();
        Auth::login($user);

        UserCourse::factory()->count(6)->create(['user_id' => $user->id]);
        $list = $this->service->getUserBuyCourses(1, 2);
        $this->assertEquals(6, $list['total']);
        $this->assertEquals(2, count($list['list']));
    }

    public function test_getUserBuyVideos()
    {
        $user = User::factory()->create();
        Auth::login($user);

        UserVideo::factory()->count(5)->create(['user_id' => $user->id]);
        $list = $this->service->getUserBuyVideos(2, 2);
        $this->assertEquals(5, $list['total']);
        $this->assertEquals(2, count($list['list']));
    }

    public function test_changeRole()
    {
        $user = User::factory()->create([
            'role_id' => 0,
        ]);
        Auth::login($user);

        $role = Role::factory()->create();

        $expiredAt = Carbon::now()->addDays($role->expire_days);
        $this->service->changeRole($user->id, $role->id, $expiredAt->toDateTimeString());

        $user->refresh();
        $this->assertEquals($role->id, $user->role_id);
        $this->assertEquals($expiredAt->toDateTimeString(), $user->role_expired_at);
    }

    public function test_hasCourse()
    {
        $user = User::factory()->create([
            'role_id' => 0,
        ]);
        $course = Course::factory()->create();

        $this->assertFalse($this->service->hasCourse($user->id, $course->id));

        UserCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $this->assertTrue($this->service->hasCourse($user->id, $course->id));
    }

    public function test_hasVideo()
    {
        $user = User::factory()->create([
            'role_id' => 0,
        ]);
        $video = Video::factory()->create();

        $this->assertFalse($this->service->hasVideo($user->id, $video->id));

        UserVideo::factory()->create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);

        $this->assertTrue($this->service->hasVideo($user->id, $video->id));
    }

    public function test_findNickname()
    {
        User::factory()->create([
            'nick_name' => 'meedu',
        ]);
        $this->assertNotEmpty($this->service->findNickname('meedu'));
    }


    public function test_getCurrentUserCourseCount()
    {
        config(['meedu.system.cache.status' => 1]);
        $user = User::factory()->create();
        UserCourse::factory()->count(10)->create(['user_id' => $user]);

        $this->assertEquals(10, $this->service->getUserCourseCount($user['id']));

        UserCourse::factory()->count(3)->create(['user_id' => $user]);
        $this->assertEquals(10, $this->service->getUserCourseCount($user['id']));
    }

    public function test_getCurrentUserVideoCount()
    {
        config(['meedu.system.cache.status' => 1]);
        $user = User::factory()->create();
        UserVideo::factory()->count(11)->create(['user_id' => $user]);

        $this->assertEquals(11, $this->service->getUserVideoCount($user['id']));

        UserVideo::factory()->count(5)->create(['user_id' => $user]);
        $this->assertEquals(11, $this->service->getUserVideoCount($user['id']));
    }

    public function test_changeMobile()
    {
        $user = User::factory()->create(['mobile' => '199000012341']);
        $this->service->changeMobile($user->id, '188999900011');
        $user->refresh();
        $this->assertEquals('188999900011', $user->mobile);
    }

    public function test_changeMobile_exists()
    {
        $this->expectException(ServiceException::class);

        $user = User::factory()->create(['mobile' => '199000012341']);
        $user = User::factory()->create(['mobile' => '13788889999']);
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
