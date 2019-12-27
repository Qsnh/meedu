<?php


namespace Tests\Services\Member;


use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Services\UserService;
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
        $this->service->bindMobile($user->id, '13909098080');
    }

    public function test_bindMobile_with_need()
    {
        $user = factory(User::class)->create([
            'mobile' => '23090909090',
            'password' => Hash::make('123456'),
        ]);
        $this->service->bindMobile($user->id, '13909098080');

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
        $this->service->bindMobile($user->id, $user2->mobile);
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
        $user = factory(User::class)->create();
        Auth::login($user);

        $page = $this->service->messagePaginate(1, 5);
        // todo 更详细的测试
        $this->assertEquals(0, $page['total']);
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

}