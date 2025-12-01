<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Member;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use App\Events\UserRegisterEvent;
use App\Events\UserVideoWatchedEvent;
use App\Exceptions\ServiceException;
use App\Services\Course\Models\Course;
use App\Services\Course\Models\Video;
use App\Services\Member\Interfaces\UserServiceInterface;
use App\Services\Member\Models\Role;
use App\Services\Member\Models\User;
use App\Services\Member\Models\UserCourse;
use App\Services\Member\Models\UserLikeCourse;
use App\Services\Member\Models\UserVideo;
use App\Services\Member\Models\UserVideoWatchRecord;
use App\Services\Member\Models\UserWatchStat;
use App\Services\Member\Notifications\SimpleMessageNotification;
use App\Services\Member\Services\NotificationService;

class UserServiceTest extends TestCase
{
    use WithFaker;

    /**
     * @var UserServiceInterface
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
        $this->service = $this->app->make(UserServiceInterface::class);

        config([
            'meedu.member.default_avatar' => 'default-avatar.png',
            'meedu.member.is_lock_default' => 1,
            'meedu.member.is_active_default' => 1,
        ]);
    }

    public function test_findMobile_returns_empty_result_when_user_missing()
    {
        $this->assertEmpty($this->service->findMobile('13000000000'));
    }

    public function test_findMobile_returns_user_array_when_user_exists()
    {
        $user = User::factory()->create([
            'mobile' => '13090909090',
        ]);
        $u = $this->service->findMobile($user->mobile);
        $this->assertNotEmpty($u);
        $this->assertEquals($user->id, $u['id']);
    }

    public function test_passwordLogin_returns_empty_when_user_not_found()
    {
        $this->assertSame([], $this->service->passwordLogin('18818818818', 'password'));
    }

    public function test_passwordLogin_returns_empty_when_password_invalid()
    {
        $user = User::factory()->create([
            'mobile' => '13909090909',
            'password' => Hash::make('secret'),
        ]);

        $this->assertSame([], $this->service->passwordLogin($user->mobile, 'wrong'));
    }

    public function test_passwordLogin_returns_user_data_when_credentials_match()
    {
        $user = User::factory()->create([
            'mobile' => '13888888888',
            'password' => Hash::make('secret'),
        ]);

        $result = $this->service->passwordLogin($user->mobile, 'secret');

        $this->assertNotEmpty($result);
        $this->assertEquals($user->id, $result['id']);
    }

    public function test_changePassword_updates_password_and_sets_flag()
    {
        $user = User::factory()->create();
        $this->service->changePassword($user->id, 'new-password');
        $user->refresh();

        $this->assertTrue(Hash::check('new-password', $user->password));
        $this->assertEquals(1, $user->is_password_set);
    }

    public function test_createWithoutMobile_uses_defaults_and_dispatches_event()
    {
        config([
            'meedu.member.default_avatar' => 'default-avatar.jpg',
            'meedu.member.is_lock_default' => 2,
            'meedu.member.is_active_default' => 3,
        ]);
        Event::fake([UserRegisterEvent::class]);

        $extra = ['channel' => 'mini-program'];
        $user = $this->service->createWithoutMobile('', '', $extra);

        $model = User::query()->findOrFail($user['id']);
        $this->assertEquals('default-avatar.jpg', $model->getRawOriginal('avatar'));
        $this->assertEquals(2, $model->is_lock);
        $this->assertEquals(3, $model->is_active);
        $this->assertEquals(0, $model->is_set_nickname);

        Event::assertDispatched(UserRegisterEvent::class, function ($event) use ($model, $extra) {
            return $event->userId === $model->id && $event->extra === $extra;
        });
    }

    public function test_createWithoutMobile_with_custom_values_persists_attributes()
    {
        Event::fake([UserRegisterEvent::class]);

        $user = $this->service->createWithoutMobile('custom-avatar.png', 'Custom Nick', ['key' => 'value']);

        $model = User::query()->findOrFail($user['id']);
        $this->assertEquals('custom-avatar.png', $model->getRawOriginal('avatar'));
        $this->assertEquals('Custom Nick', $model->nick_name);
    }

    public function test_createWithMobile_with_explicit_values()
    {
        Event::fake([UserRegisterEvent::class]);

        $result = $this->service->createWithMobile('13909090909', 'secret', 'Nick', 'avatar-path.png', ['scene' => 'test']);

        $model = User::query()->findOrFail($result['id']);
        $this->assertEquals('13909090909', $model->mobile);
        $this->assertTrue(Hash::check('secret', $model->password));
        $this->assertEquals('Nick', $model->nick_name);
        $this->assertEquals('avatar-path.png', $model->getRawOriginal('avatar'));
        $this->assertEquals(1, $model->is_set_nickname);
        $this->assertEquals(1, $model->is_password_set);

        Event::assertDispatched(UserRegisterEvent::class, function ($event) use ($model) {
            return $event->userId === $model->id;
        });
    }

    public function test_createWithMobile_uses_defaults_when_optional_values_missing()
    {
        config([
            'meedu.member.default_avatar' => 'from-config.png',
        ]);
        Event::fake([UserRegisterEvent::class]);

        $result = $this->service->createWithMobile('13900000000', '', '', '');

        $model = User::query()->findOrFail($result['id']);
        $this->assertEquals('from-config.png', $model->getRawOriginal('avatar'));
        $this->assertEquals(0, $model->is_set_nickname);
        $this->assertEquals(0, $model->is_password_set);
        $this->assertEquals(12, strlen($model->nick_name));
        $this->assertNotEmpty($model->password);
    }

    public function test_updateAvatar_updates_user_avatar()
    {
        $user = User::factory()->create();
        $avatar = $this->faker->imageUrl();
        $this->service->updateAvatar($user->id, $avatar);
        $user->refresh();
        $this->assertEquals($avatar, $user->avatar);
    }

    public function test_find_returns_user_with_requested_relations()
    {
        $role = Role::factory()->create();
        $user = User::factory()->create(['role_id' => $role->id]);

        $result = $this->service->find($user->id, ['role']);

        $this->assertEquals($role->id, $result['role']['id']);
    }

    public function test_updateNickname_updates_value_and_marks_flag()
    {
        $user = User::factory()->create([
            'is_set_nickname' => 0,
            'nick_name' => 'old',
        ]);

        $this->service->updateNickname($user->id, 'new-nickname');
        $user->refresh();

        $this->assertEquals('new-nickname', $user->nick_name);
        $this->assertEquals(1, $user->is_set_nickname);
    }

    public function test_updateNickname_throws_when_already_set()
    {
        $this->expectException(ServiceException::class);

        $user = User::factory()->create([
            'is_set_nickname' => 1,
        ]);

        $this->service->updateNickname($user->id, 'any-nickname');
    }

    public function test_updateNickname_throws_when_nickname_exists()
    {
        $this->expectException(ServiceException::class);

        $existing = User::factory()->create([
            'nick_name' => 'duplicate',
        ]);
        $user = User::factory()->create([
            'is_set_nickname' => 0,
        ]);

        $this->service->updateNickname($user->id, $existing->nick_name);
    }

    public function test_messagePaginate_returns_paginated_notifications()
    {
        $notificationService = $this->app->make(NotificationService::class);
        $user = User::factory()->create();

        $notificationService->notifyRegisterMessage($user->id);
        $notificationService->notifyRegisterMessage($user->id);

        $page1 = $this->service->messagePaginate($user['id'], 1, 1);
        $this->assertEquals(2, $page1['total']);
        $this->assertCount(1, $page1['list']);

        $page2 = $this->service->messagePaginate($user['id'], 2, 1);
        $this->assertEquals(2, $page2['total']);
        $this->assertCount(1, $page2['list']);
    }

    public function test_getUserBuyCourses_returns_paginated_result()
    {
        $user = User::factory()->create();

        UserCourse::factory()->count(6)->create(['user_id' => $user['id']]);
        $list = $this->service->getUserBuyCourses($user['id'], 1, 2);
        $this->assertEquals(6, $list['total']);
        $this->assertCount(2, $list['list']);
    }

    public function test_hasCourse_checks_user_purchase_status()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->assertFalse($this->service->hasCourse($user->id, $course->id));

        UserCourse::factory()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $this->assertTrue($this->service->hasCourse($user->id, $course->id));
    }

    public function test_getUserBuyVideosIn_returns_owned_videos_only()
    {
        $user = User::factory()->create();
        $videos = Video::factory()->count(3)->create();

        UserVideo::factory()->create(['user_id' => $user->id, 'video_id' => $videos[0]->id]);
        UserVideo::factory()->create(['user_id' => $user->id, 'video_id' => $videos[2]->id]);

        $result = $this->service->getUserBuyVideosIn($user->id, $videos->pluck('id')->toArray());

        $this->assertEqualsCanonicalizing([$videos[0]->id, $videos[2]->id], $result);
    }

    public function test_hasVideo_checks_user_video_purchase_status()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $this->assertFalse($this->service->hasVideo($user->id, $video->id));

        UserVideo::factory()->create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);

        $this->assertTrue($this->service->hasVideo($user->id, $video->id));
    }

    public function test_changeRole_updates_role_and_expired_at()
    {
        $user = User::factory()->create([
            'role_id' => 0,
        ]);

        $role = Role::factory()->create();

        $expiredAt = Carbon::now()->addDays($role->expire_days);
        $this->service->changeRole($user->id, $role->id, $expiredAt->toDateTimeString());

        $user->refresh();
        $this->assertEquals($role->id, $user->role_id);
        $this->assertEquals($expiredAt->toDateTimeString(), $user->role_expired_at);
    }

    public function test_changeMobile_updates_mobile_number()
    {
        $user = User::factory()->create(['mobile' => '199000012341']);
        $this->service->changeMobile($user->id, '188999900011');
        $user->refresh();
        $this->assertEquals('188999900011', $user->mobile);
    }

    public function test_changeMobile_throws_when_mobile_already_exists()
    {
        $this->expectException(ServiceException::class);

        $existing = User::factory()->create(['mobile' => '13788889999']);
        $user = User::factory()->create(['mobile' => '199000012341']);

        $this->service->changeMobile($user->id, $existing->mobile);
    }

    public function test_notificationMarkAsRead_marks_single_notification()
    {
        $user = User::factory()->create();
        $user->notify(new SimpleMessageNotification('test message'));

        $notification = $user->unreadNotifications->first();
        $this->service->notificationMarkAsRead($user->id, $notification->id);

        $user->refresh();
        $this->assertEquals(0, $user->unreadNotifications->count());
    }

    public function test_notificationMarkAllAsRead_marks_all_notifications()
    {
        $user = User::factory()->create();
        $user->notify(new SimpleMessageNotification('message1'));
        $user->notify(new SimpleMessageNotification('message2'));

        $this->service->notificationMarkAllAsRead($user->id);

        $user->refresh();
        $this->assertEquals(0, $user->unreadNotifications->count());
    }

    public function test_unreadNotificationCount_returns_current_unread_total()
    {
        $user = User::factory()->create();
        $user->notify(new SimpleMessageNotification('message1'));
        $user->notify(new SimpleMessageNotification('message2'));

        $this->assertEquals(2, $this->service->unreadNotificationCount($user->id));
    }

    public function test_likeACourse_toggles_like_state()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->assertEquals(1, $this->service->likeACourse($user->id, $course->id));
        $this->assertTrue($this->service->likeCourseStatus($user->id, $course->id));

        $this->assertEquals(0, $this->service->likeACourse($user->id, $course->id));
        $this->assertFalse($this->service->likeCourseStatus($user->id, $course->id));
    }

    public function test_likeCourseStatus_reflects_database_state()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $this->assertFalse($this->service->likeCourseStatus($user->id, $course->id));

        UserLikeCourse::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $this->assertTrue($this->service->likeCourseStatus($user->id, $course->id));
    }

    public function test_recordUserVideoWatch_creates_and_updates_records()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $video = Video::factory()->create();

        Event::fake([UserVideoWatchedEvent::class]);
        Carbon::setTestNow(Carbon::now());

        $this->service->recordUserVideoWatch($user->id, $course->id, $video->id, 120, true);

        $record = UserVideoWatchRecord::query()->where('user_id', $user->id)->where('video_id', $video->id)->first();
        $this->assertNotNull($record);
        $this->assertEquals(120, $record->watch_seconds);
        $this->assertNotNull($record->watched_at);

        Event::assertDispatchedTimes(UserVideoWatchedEvent::class, 1);

        Event::fake([UserVideoWatchedEvent::class]);

        $record->update(['watch_seconds' => 60, 'watched_at' => null]);
        $this->service->recordUserVideoWatch($user->id, $course->id, $video->id, 90, false);
        $record->refresh();
        $this->assertEquals(90, $record->watch_seconds);
        $this->assertNull($record->watched_at);
        Event::assertNotDispatched(UserVideoWatchedEvent::class);

        $this->service->recordUserVideoWatch($user->id, $course->id, $video->id, 150, true);
        $record->refresh();
        $this->assertNotNull($record->watched_at);
        Event::assertDispatchedTimes(UserVideoWatchedEvent::class, 1);

        Carbon::setTestNow();
    }

    public function test_getUserVideoWatchRecords_returns_records_for_course()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();
        $videoOne = Video::factory()->create();
        $videoTwo = Video::factory()->create();

        UserVideoWatchRecord::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'video_id' => $videoOne->id,
            'watch_seconds' => 30,
        ]);
        UserVideoWatchRecord::query()->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'video_id' => $videoTwo->id,
            'watch_seconds' => 45,
        ]);

        $records = $this->service->getUserVideoWatchRecords($user->id, $course->id);
        $this->assertCount(2, $records);
    }

    public function test_setRegisterIp_updates_user_ip()
    {
        $user = User::factory()->create();
        $this->service->setRegisterIp($user->id, '127.0.0.1');
        $user->refresh();
        $this->assertEquals('127.0.0.1', $user->register_ip);
    }

    public function test_setRegisterArea_updates_only_when_value_present()
    {
        $user = User::factory()->create(['register_area' => 'old']);

        $this->service->setRegisterArea($user->id, '');
        $user->refresh();
        $this->assertEquals('old', $user->register_area);

        $this->service->setRegisterArea($user->id, 'new area');
        $user->refresh();
        $this->assertEquals('new area', $user->register_area);
    }

    public function test_resetRoleExpiredUsers_only_updates_expired_records()
    {
        $expired = User::factory()->create([
            'role_id' => 2,
            'role_expired_at' => Carbon::now()->subDay(),
        ]);
        $active = User::factory()->create([
            'role_id' => 3,
            'role_expired_at' => Carbon::now()->addDay(),
        ]);

        $count = $this->service->resetRoleExpiredUsers();

        $this->assertEquals(1, $count);

        $expired->refresh();
        $this->assertEquals(0, $expired->role_id);
        $this->assertNull($expired->role_expired_at);

        $active->refresh();
        $this->assertEquals(3, $active->role_id);
    }

    public function test_watchStatSave_creates_and_updates_daily_stat()
    {
        $userId = 1;

        $this->service->watchStatSave($userId, 10);

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

    public function test_inviteCount_returns_number_of_invited_users()
    {
        $inviter = User::factory()->create();
        User::factory()->count(3)->create(['invite_user_id' => $inviter->id]);

        $this->assertEquals(3, $this->service->inviteCount($inviter->id));
    }

    public function test_clearVideoWatchRecords_removes_records_for_video()
    {
        $videoOne = Video::factory()->create();
        $videoTwo = Video::factory()->create();

        UserVideoWatchRecord::query()->create([
            'user_id' => 1,
            'course_id' => 1,
            'video_id' => $videoOne->id,
            'watch_seconds' => 30,
        ]);
        UserVideoWatchRecord::query()->create([
            'user_id' => 1,
            'course_id' => 1,
            'video_id' => $videoTwo->id,
            'watch_seconds' => 45,
        ]);

        $this->service->clearVideoWatchRecords($videoOne->id);

        $this->assertNull(UserVideoWatchRecord::query()->where('video_id', $videoOne->id)->first());
        $this->assertNotNull(UserVideoWatchRecord::query()->where('video_id', $videoTwo->id)->first());
    }
}
