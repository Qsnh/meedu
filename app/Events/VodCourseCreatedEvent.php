<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class VodCourseCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;

    public $data = [];

    public function __construct($courseId, $title, $charge, $thumb, $shortDesc, $desc)
    {
        $this->id = $courseId;
        $this->data = [
            'title' => $title,
            'charge' => $charge,
            'thumb' => $thumb,
            'short_desc' => $shortDesc,
            'desc' => $desc,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
