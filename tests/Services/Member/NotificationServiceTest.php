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

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Services\Member\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class NotificationServiceTest extends TestCase
{

    /**
     * @var NotificationService
     */
    protected $service;

    public function setUp():void
    {
        parent::setUp();
        $this->service = $this->app->make(NotificationServiceInterface::class);
    }

    public function test_notify()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $this->service->notifyOrderPaidMessage($user->id, Str::random());
        $unreadCount = $this->service->getUnreadCount();
        $this->assertEquals(1, $unreadCount);

        $this->service->notifyRegisterMessage($user->id);
        $this->service->notifyBindMobileMessage($user->id);
        $this->service->notifyAtNotification($user->id, $user->id, 'course', 'link');
        $unreadCount = $this->service->getUnreadCount();
        $this->assertEquals(4, $unreadCount);
        $this->assertEquals(4, $this->service->getUserUnreadCount($user->id));

        $this->service->markAllRead($user->id);
        $this->assertEquals(0, $this->service->getUnreadCount());
    }
}
