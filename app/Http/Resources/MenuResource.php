<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'tags' => $this->tags,
            'active' => $this->active >= 1 ? true : false,
            'image' => url()->route('image', ['path' => $this->image, 'w' => 500, 'h' => 500, 'fit' => 'crop']),
            'image_large' => url()->route('image', ['path' => $this->image, 'w' => 800, 'h' => 800, 'fit' => 'crop']),
            'category' => new CategoryResource($this->category),
        ];
    }
}
