<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'user' => [
              'id' => $this->user->id,
              'name' => $this->user->name,
              'email' => $this->user->email,
            ],
            'table' => [
              'id' => $this->table->id,
              'no' => $this->table->no,
              'status' => $this->table->status,
              'capacity' => $this->table->capacity
            ],
            'date' => $this->date,
            'time' => $this->time,
            'persons' => $this->persons,
            'status' => $this->status,
            'notes' => $this->notes
        ];
    }
}
