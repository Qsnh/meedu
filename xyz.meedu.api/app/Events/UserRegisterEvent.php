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
    public $extra;

    /**
     * @param int $userId
     * @param array $extra
     *
     * @codeCoverageIgnore
     */
    public function __construct(int $userId, array $extra = [])
    {
        $this->userId = $userId;
        $this->extra = $extra;
    }
}
