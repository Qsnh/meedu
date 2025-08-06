<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserRegisterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $mobile;

    public function __construct(int $userId, string $mobile = '')
    {
        $this->userId = $userId;
        $this->mobile = $mobile;
    }
}