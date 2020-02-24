<?php


namespace Tests\Services\Member;


use App\Services\Member\Interfaces\RoleServiceInterface;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Member\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{

    /**
     * @var RoleService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = $this->app->make(RoleServiceInterface::class);
    }

    public function test_all()
    {
        factory(Role::class, 5)->create();
        $all = $this->service->all();
        $this->assertNotEmpty($all);
        $this->assertEquals(5, count($all));
    }

    public function test_find()
    {
        $role = factory(Role::class)->create();
        $r = $this->service->find($role->id);
        $this->assertEquals($role->name, $r['name']);
    }

    public function test_userRolePaginate()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        factory(UserJoinRoleRecord::class, 6)->create([
            'user_id' => $user->id,
        ]);
        $list = $this->service->userRolePaginate(2, 3);
        $this->assertEquals(6, $list['total']);
        $this->assertEquals(3, count($list['list']));
    }

    public function test_userJoinRole()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $role = factory(Role::class)->create(['expire_days' => 1]);

        $this->service->userJoinRole($user->toArray(), $role->toArray(), 1);

        $record = UserJoinRoleRecord::whereUserId($user->id)->whereRoleId($role->id)->whereCharge(1)->exists();
        $this->assertTrue($record);

        $user->refresh();
        $this->assertEquals($role->id, $user->role_id);
        $this->assertTrue(abs(Carbon::now()->addDays($role->expire_days)->timestamp - strtotime($user->role_expired_at)) < 5);
    }

    public function test_userContinueRole()
    {
        $role = factory(Role::class)->create(['expire_days' => 1]);

        $now = Carbon::now()->addDays(1);
        $user = factory(User::class)->create([
            'role_id' => $role->id,
            'role_expired_at' => $now,
        ]);
        Auth::login($user);

        $this->service->userContinueRole($user->toArray(), $role->toArray(), 1);

        $record = UserJoinRoleRecord::whereUserId($user->id)->whereRoleId($role->id)->whereCharge(1)->exists();
        $this->assertTrue($record);

        $user->refresh();
        $this->assertTrue(abs($now->addDays($role->expire_days)->timestamp - strtotime($user->role_expired_at)) < 5);
    }

}