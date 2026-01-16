<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'phone' => $this->resource->phone,
            'personIdImage' => $this->resource->personIdImage ? Storage::url($this->resource->personIdImage) : null,
            'profileImage' => $this->resource->profileImage ? Storage::url($this->resource->profileImage) : null,
            'birthdate' => $this->resource->birthdate,
            'verification_state' => $this->resource->verification_state,
            'wallet_balance' => $this->resource->wallet_balance,
            'location' => [
                'governorate' => $this->resource->location['governorate'] ?? null,
                'city' => $this->resource->location['city'] ?? null,
                'district' => $this->resource->location['district'] ?? null,
                'street' => $this->resource->location['street'] ?? null,
            ],
        ];
        return $data;
    }
}
