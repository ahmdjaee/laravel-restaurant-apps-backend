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
            'cart_id' => $this->cart_id,
            'quantity' => $this->quantity,
            'total_quantity' => $this->total_quantity,
            'total_price' => $this->quantity * $this->menu->price,
            'notes' => $this->notes,
            'menu' => [
                'id' => $this->menu->id,
                'name' => $this->menu->name,
                'price' => $this->menu->price,
                'image' => $this->menu->image,
                'category' => $this->menu->category_id,
                'description' => $this->menu->description,
            ],
        ];
    }
}
