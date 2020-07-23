<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserLoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;

    public $platform;

    /**
     * UserLoginEvent constructor.
     * @param int $userId
     * @param string $platform
     */
    public function __construct(int $userId, string $platform = '')
    {
        $this->userId = $userId;
        $this->platform = $platform;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     *
     * @codeCoverageIgnore
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
