<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $role = [];
        if ($this->role) {
            $role = [
                'role' => $this->role->name,
                'expired_at' => strtotime($this->role_expired_at),
            ];
        }

        return [
            'avatar' => $this->avatar,
            'nick_name' => $this->nick_name,
            'mobile' => $this->mobile,
            'role' => $role,
            'unread_notification_num' => $this->unreadNotifications->count(),
            'credit1' => $this->credit1,
        ];
    }
}
