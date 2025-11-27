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
            'description' => $this->resource->description,
            'area' => $this->resource->area,
            'bedrooms' => $this->resource->bedrooms,
            'bathrooms' => $this->resource->bathrooms,
            'floor' => $this->resource->floor,
            'rentFee' => $this->resource->rentFee,
            'isAvailable' => $this->resource->isAvailable,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'average_rating' => $this->resource->average_rating,
            'review_count' => $this->resource->review_count,
            'location' => [
                'governorate' => $this->resource->location['governorate'] ?? null,
                'city' => $this->resource->location['city'] ?? null,
                'district' => $this->resource->location['district'] ?? null,
                'street' => $this->resource->location['street'] ?? null,
            ],

        ];
        if ($this->relationLoaded('images')) {
            $data['images'] = $this->resource->images->map(fn($img) => $img->path);
        }
        if ($this->relationLoaded('user')) {
            $data['user'] = new UserResource($this->resource->user);
        }
        if ($this->relationLoaded('reviews')) {
            $data['reviews'] = ReviewResource::collection($this->resource->reviews);
        }
        return $data;
    }
}
