<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserNotificationReadEvent
{
    use Dispatchable, SerializesModels;

    public $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
