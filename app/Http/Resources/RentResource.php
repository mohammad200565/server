<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'endRent' => $this->resource->endRent,
            'startRent' => $this->resource->startRent,
            'status' => $this->resource->status,
            'rentFee' => $this->resource->rentFee,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'user_id' => $this->resource->user_id,
            'department_id' => $this->resource->department_id,
        ];
    }
}
