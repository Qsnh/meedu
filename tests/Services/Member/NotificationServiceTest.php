<?php


namespace Tests\Services\Member;


use App\Services\Member\Interfaces\NotificationServiceInterface;
use App\Services\Member\Models\User;
use App\Services\Member\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{

    /**
     * @var NotificationService
     */
    protected $service;

    public function setUp()
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