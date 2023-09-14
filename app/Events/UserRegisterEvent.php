<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserRegisterEvent
{
    use Dispatchable, SerializesModels;

    public $userId;

    /**
     * @param int $userId
     *
     * @codeCoverageIgnore
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
