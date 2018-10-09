<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $role = [];
        if ($this->role) {
            $role = [
                'role' => $this->role->name,
                'expired_at' => $this->role_expired_at,
            ];
        }
        return [
            'avatar' => $this->avatar,
            'nick_name' => $this->nick_name,
            'mobile' => $this->mobile,
            'role' => $role,
        ];
    }
}
