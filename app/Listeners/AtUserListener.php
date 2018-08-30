<?php

namespace App\Listeners;

use App\Events\AtUserEvent;
use App\Notifications\AtUserNotification;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AtUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AtUserEvent  $event
     * @return void
     */
    public function handle(AtUserEvent $event)
    {
        $fromUser = $event->fromUser;
        $toUserNickName = $event->toUserNickName;
        $comment = $event->comment;
        $commentType = $event->commentType;

        $toUser = User::where('nick_name', $toUserNickName)->first();

        if ($toUser->id == $fromUser->id) {
            return;
        }

        if (! $toUser) {
            Log::error('AtEvent' . $toUserNickName);
            return;
        }

        $toUser->notify(new AtUserNotification($fromUser, $commentType, $comment->id));
    }
}
