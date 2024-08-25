<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'quantity' => $this->quantity,
            'notes' => $this->notes,
            'menu' => [
                'id' => $this->menu->id,
                'name' => $this->menu->name,
                'price' => $this->menu->price,
                'image' => url()->route('image', ['path' => $this->menu->image, 'w' => 300, 'h' => 300, 'fit' => 'crop']),
                'category' => $this->menu->category,
                'description' => $this->menu->description,
            ],
        ];
    }
}
