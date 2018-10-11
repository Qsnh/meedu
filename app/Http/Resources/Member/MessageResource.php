<?php

namespace App\Http\Resources\Member;

use App\Meedu\NotificationParse;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'content' => (new NotificationParse())->parseText($this),
        ];
    }
}
