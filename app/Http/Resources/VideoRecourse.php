<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoRecourse extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'thumb' => $this->thumb,
            'view_num' => $this->view_num,
            'charge' => $this->charge,
            'short_description' => markdown_to_html($this->short_description),
            'description' => markdown_to_html($this->description),
            'published_at' => $this->published_at,
        ];
    }
}
