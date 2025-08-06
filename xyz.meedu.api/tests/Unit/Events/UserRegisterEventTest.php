<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace Tests\Unit\Events;

use Tests\TestCase;
use App\Events\UserRegisterEvent;
use Illuminate\Support\Facades\Event;

class UserRegisterEventTest extends TestCase
{
    public function test_UserRegisterEvent()
    {
        Event::fake();
        event(new UserRegisterEvent(1, '13800138000'));
        Event::assertDispatched(UserRegisterEvent::class, function ($event) {
            return $event->userId === 1 && $event->mobile === '13800138000';
        });
    }
}