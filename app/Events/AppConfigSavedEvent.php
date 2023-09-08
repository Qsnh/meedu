<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class AppConfigSavedEvent
{
    use Dispatchable, SerializesModels;

    public $newConfig;
    public $oldConfig;

    public function __construct(array $newConfig, array $oldConfig)
    {
        $this->newConfig = $newConfig;
        $this->oldConfig = $oldConfig;
    }
}
