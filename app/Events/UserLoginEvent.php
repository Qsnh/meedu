<?php

/*
 * This file is part of the MeEdu.
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
    public $ip;
    public $token;
    public $ua;

    public function __construct(int $userId, string $platform, string $ip, string $ua, string $token)
    {
        $this->userId = $userId;
        $this->platform = $platform;
        $this->ip = $ip;
        $this->ua = $ua;
        $this->token = $token;
    }
}
