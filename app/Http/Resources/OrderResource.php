<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'items' => $this->order_items,
            'reservation' => $this->reservation,
            'status' => $this->status,
            'token' => $this->token,
            'total_payment' => $this->total_payment,
        ];
    }
}
