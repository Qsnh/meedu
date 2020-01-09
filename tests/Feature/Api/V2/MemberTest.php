<?php


namespace Tests\Feature\Api\V2;


use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserInviteBalanceRecord;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Member\Models\UserVideo;
use App\Services\Order\Models\Order;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MemberTest extends Base
{

    protected $member;

    public function setUp()
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
        $cacheService->put('m:' . $this->member->mobile, 'code', 10);
        $response = $this->user($this->member)->postJson('api/v2/member/detail/password', [
            'mobile_code' => 'code',
            'mobile' => $this->member->mobile,
            'password' => '123123',
        ]);
        $this->assertResponseSuccess($response);
        $this->member->refresh();
        $this->assertTrue(Hash::check('123123', $this->member->password));
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

}