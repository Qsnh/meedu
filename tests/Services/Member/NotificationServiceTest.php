<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Services\Member;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Services\Member\Models\User;
use App\Services\Member\Services\NotificationService;
use App\Services\Member\Interfaces\NotificationServiceInterface;

class NotificationServiceTest extends TestCase
{

    /**
     * @var NotificationService
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(NotificationServiceInterface::class);
    }

    public function test_notify()
    {
        $user = User::factory()->create();

        $this->service->notifyOrderPaidMessage($user['id'], Str::random());
        $unreadCount = $this->service->getUnreadCount($user['id']);
        $this->assertEquals(1, $unreadCount);

        $this->service->notifyRegisterMessage($user['id']);
        $this->service->notifyBindMobileMessage($user['id']);
        $unreadCount = $this->service->getUnreadCount($user['id']);
        $this->assertEquals(3, $unreadCount);
        $this->assertEquals(3, $this->service->getUserUnreadCount($user['id']));

        $this->service->markAllRead($user['id']);
        $this->assertEquals(0, $this->service->getUnreadCount($user['id']));
    }
}
