<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EditedRentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'endRent' => $this->resource->endRent,
            'startRent' => $this->resource->startRent,
            'status' => $this->resource->status,
            'rentFee' => $this->resource->rentFee,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];

        if ($this->resource->relationLsoaded('rent')) {
            $data['rent'] = new RentResource($this->resource->rent);
        }

        if ($this->resource->relationLoaded('user')) {
            $data['user'] = new UserResource($this->resource->user);
        }
        if ($this->resource->relationLoaded('department')) {
            $data['department'] = new DepartmentResource($this->resource->department);
        }
        return $data;
    }
}
