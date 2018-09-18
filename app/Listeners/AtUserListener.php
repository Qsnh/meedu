<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Listeners;

use App\User;
use App\Events\AtUserEvent;
use Illuminate\Support\Facades\Log;
use App\Notifications\AtUserNotification;

class AtUserListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param AtUserEvent $event
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
            Log::error('AtEvent'.$toUserNickName);

            return;
        }

        $toUser->notify(new AtUserNotification($fromUser, $commentType, $comment->id));
    }
}
