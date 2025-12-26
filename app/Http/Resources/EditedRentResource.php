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

        if (isset($this->resource->original_rent)) {
            $data['original_rent'] = new RentResource($this->resource->original_rent);
        }

        if (isset($this->resource->user)) {
            $data['user'] = new UserResource($this->resource->user);
        }
        
        if (isset($this->resource->department)) {
            $data['department'] = new DepartmentResource($this->resource->department);
        }
        
        return $data;
    }
}