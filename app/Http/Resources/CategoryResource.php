<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'image' => url()->route('image', ['path' => $this->image, 'w' => 300, 'h' => 300, 'fit' => 'crop']),
            'image_large' => url()->route('image', ['path' => $this->image, 'w' => 800, 'h' => 800, 'fit' => 'crop']),
        ];
    }
}
