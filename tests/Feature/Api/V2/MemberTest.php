<?php


namespace Tests\Feature\Api\V2;


use App\Services\Base\Interfaces\CacheServiceInterface;
use App\Services\Course\Models\CourseUserRecord;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserInviteBalanceRecord;
use App\Services\Member\Models\UserJoinRoleRecord;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Notifications\SimpleMessageNotification;
use App\Services\Order\Models\Order;
use App\Services\Order\Models\PromoCode;
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

}