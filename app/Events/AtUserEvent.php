<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AtUserEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $fromUser;

    public $toUserNickName;

    public $comment;

    public $commentType;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $fromUser, $toUserNickName, $comment, $commentType)
    {
        $this->fromUser = $fromUser;
        $this->toUserNickName = $toUserNickName;
        $this->comment = $comment;
        $this->commentType = $commentType;
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
