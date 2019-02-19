<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Resources\Member;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleBuyResource extends JsonResource
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
        return [
            'role' => [
                'name' => $this->role->name,
                'charge' => $this->role->charge,
                'expire_days' => $this->role->expire_days,
                'description' => $this->role->descriptionRows(),
            ],
            'charge' => $this->charge,
            'started_at' => strtotime($this->started_at),
            'expired_at' => strtotime($this->expired_at),
        ];
    }
}
