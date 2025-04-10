<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class VodVideoCreatedEvent
{
    use Dispatchable, SerializesModels;

    public $id;

    /**
     * @param $id
     *
     * @codeCoverageIgnore
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
