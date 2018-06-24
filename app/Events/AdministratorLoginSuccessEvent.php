<?php

namespace App\Events;

use App\Models\Administrator;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AdministratorLoginSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $administrator;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Administrator $administrator)
    {
        $this->administrator = $administrator;
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
