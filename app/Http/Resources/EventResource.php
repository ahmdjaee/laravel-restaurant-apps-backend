<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => url()->route('image', ['path' => $this->image, 'w' => 300, 'h' => 300, 'fit' => 'crop']),
            'image_large' => url()->route('image', ['path' => $this->image, 'fit' => 'crop']),
            'type' => $this->type,
            'active' => $this->whenNotNull($this->active == 1 ? true : false, true),
            'event_start' => $this->event_start,
            'event_end' => $this->event_end,
        ];
    }
}
