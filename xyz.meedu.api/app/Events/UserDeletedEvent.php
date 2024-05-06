<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserDeletedEvent
{
    use Dispatchable, SerializesModels;

    public $userId;

    /**
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
