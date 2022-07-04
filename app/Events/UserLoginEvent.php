<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserLoginEvent
{
    use Dispatchable, SerializesModels;

    public $userId;

    public $platform;

    public $at;

    /**
     * UserLoginEvent constructor.
     * @param int $userId
     * @param string $platform
     * @param string $at
     *
     * @codeCoverageIgnore
     */
    public function __construct(int $userId, string $platform = '', $at = '')
    {
        $this->userId = $userId;
        $this->platform = $platform;
        $this->at = $at;
    }
}
