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
            'user_id' => $this->user_id,
            'table_id' => $this->table_id,
            'date' => $this->date,
            'time' => $this->time,
            'persons' => $this->persons,
            'status' => $this->status,
            'notes' => $this->notes
        ];
    }
}
