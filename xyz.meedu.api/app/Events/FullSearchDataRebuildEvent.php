<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class FullSearchDataRebuildEvent
{
    use Dispatchable, SerializesModels;

    public function __construct()
    {
    }
}
