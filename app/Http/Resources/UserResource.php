<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            // 'token' =>  $this->whenNotNull($this->token),
            'is_admin' =>  $this->when($this->is_admin, true),
            'photo' =>  $this->photo ? url()->route('image', ['path' => $this->photo, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
            'photo_medium' =>  $this->photo ? url()->route('image', ['path' => $this->photo, 'w' => 300, 'h' => 300, 'fit' => 'crop']) : null,
            'photo_large' =>  $this->photo ? url()->route('image', ['path' => $this->photo, 'w' => 300, 'h' => 300, 'fit' => 'crop']) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
