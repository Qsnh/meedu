<?php


namespace Tests\Services\Member;

use App\Services\Course\Models\Course;
use App\Services\Course\Models\Video;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Services\UserService;
use App\Services\Order\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @var UserService
     */
    protected $service;

    public function setUp()
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

    /**
     * @expectedException \App\Exceptions\ServiceException
     */
    public function test_resetPassword()
    {
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

    /**
     * @expectedException \App\Exceptions\ServiceException
     */
    public function test_bindMobile()
    {
        $user = factory(User::class)->create([
            'mobile' => '13090909090',
            'password' => Hash::make('123456'),
        ]);
        Auth::login($user);
        $this->service->bindMobile('13909098080');
    }

    /**
     * @expectedException \App\Exceptions\ServiceException
     */
    public function test_bindMobile_with_exists()
    {
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

    /**
     * @expectedException \App\Exceptions\ServiceException
     */
    public function test_bindMobile_with_exist_mobile()
    {
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
        $this->service->updateInviteUserId($user1->id, $promoCode->toArray());

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
        Auth::login($user);
        $this->assertEquals(10, $this->service->getCurrentUserCourseCount());

        factory(UserCourse::class, 3)->create(['user_id' => $user]);
        $this->assertEquals(10, $this->service->getCurrentUserCourseCount());
    }

    public function test_getCurrentUserVideoCount()
    {
        config(['meedu.system.cache.status' => 1]);
        $user = factory(User::class)->create();
        factory(UserVideo::class, 11)->create(['user_id' => $user]);
        Auth::login($user);
        $this->assertEquals(11, $this->service->getCurrentUserVideoCount());

        factory(UserVideo::class, 5)->create(['user_id' => $user]);
        $this->assertEquals(11, $this->service->getCurrentUserVideoCount());
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

}