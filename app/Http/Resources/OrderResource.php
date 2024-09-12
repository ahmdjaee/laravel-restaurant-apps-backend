<?php

namespace App\Http\Resources;

use App\Models\OrderItem;
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
            'items' => OrderItemResource::collection(OrderItem::query()->where('order_id', $this->id)->get()),
            'name'=> $this->name,
            'user' => new UserResource($this->user),
            'reservation' => new ReservationResource($this->reservation),
            'status' => $this->status,
            'token' => $this->whenNotNull($this->token),
            'total_payment' => $this->total_payment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
