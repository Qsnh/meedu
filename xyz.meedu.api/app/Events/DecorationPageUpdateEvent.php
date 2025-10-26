<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class DecorationPageUpdateEvent
{
    use Dispatchable, SerializesModels;

    public $pageKey;

    /**
     * Create a new event instance.
     *
     * @param string $pageKey
     * @return void
     */
    public function __construct(string $pageKey)
    {
        $this->pageKey = $pageKey;
    }
}
