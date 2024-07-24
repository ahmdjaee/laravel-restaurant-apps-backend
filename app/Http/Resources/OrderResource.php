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
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'reservation' => [
                'id' => $this->reservation->id,
                'table' => [
                    'id' => $this->reservation->table->id,
                    'no' => $this->reservation->table->no,
                    'status' => $this->reservation->table->status,
                    'capacity' => $this->reservation->table->capacity
                ],
                'date' => $this->reservation->date,
                'time' => $this->reservation->time,
                'persons' => $this->reservation->persons,
                'status' => $this->reservation->status,
                'notes' => $this->reservation->notes
            ],
            'status' => $this->status,
            'token' => $this->whenNotNull($this->token),
            'total_payment' => $this->total_payment,
            'created_at' => $this->created_at,
        ];
    }
}
