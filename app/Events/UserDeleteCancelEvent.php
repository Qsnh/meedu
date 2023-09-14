<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserDeleteCancelEvent
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $submitAt;
    public $expiredAt;

    public function __construct(int $userId, string $submitAt, string $expiredAt)
    {
        $this->userId = $userId;
        $this->submitAt = $submitAt;
        $this->expiredAt = $expiredAt;
    }
}
