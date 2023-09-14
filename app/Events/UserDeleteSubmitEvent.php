<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserDeleteSubmitEvent
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $mobile;

    /**
     * @param $userId
     * @param $mobile
     */
    public function __construct($userId, $mobile)
    {
        $this->userId = $userId;
        $this->mobile = $mobile;
    }
}
