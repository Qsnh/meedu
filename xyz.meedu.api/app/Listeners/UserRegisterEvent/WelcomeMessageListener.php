<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Listeners\UserRegisterEvent;

use App\Events\UserRegisterEvent;
use App\Services\Member\Services\NotificationService;

class WelcomeMessageListener
{
    public function __construct(private NotificationService $notificationService) {}

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserRegisterEvent  $event
     * @return void
     */
    public function handle(UserRegisterEvent $event)
    {
        $this->notificationService->welcomeMessage($event->userId);
    }
}