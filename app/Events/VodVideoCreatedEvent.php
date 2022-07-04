<?php

/*
 * This file is part of the Qsnh/meedu.
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

    public $data = [];

    /**
     * @param $id
     * @param $title
     * @param $charge
     * @param $thumb
     * @param $shortDesc
     * @param $desc
     *
     * @codeCoverageIgnore
     */
    public function __construct($id, $title, $charge, $thumb, $shortDesc, $desc)
    {
        $this->id = $id;
        $this->data = [
            'title' => $title,
            'charge' => $charge,
            'thumb' => $thumb,
            'short_desc' => $shortDesc,
            'desc' => $desc,
        ];
    }
}
