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
            'location' => $this->resource->location,
            'phone' => $this->resource->phone,
            'personIdImage' => $this->resource->personIdImage ? Storage::url($this->resource->personIdImage) : null,
            'profileImage' => $this->resource->profileImage ? Storage::url($this->resource->profileImage) : null,
            'birthdate' => $this->resource->birthdate,
        ];
        return $data;
    }
}
