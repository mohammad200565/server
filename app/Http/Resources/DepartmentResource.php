<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user_id,
            'description' => $this->resource->description,
            'size' => $this->resource->size,
            'location' => $this->resource->location,
            'rentFee' => $this->resource->rentFee,
            'isAvailable' => $this->resource->isAvailable,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
        return $data;
    }
}
