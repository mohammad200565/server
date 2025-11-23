<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'rating' => $this->resource->rating,
            'comment' => $this->resource->comment,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
        return $data;
    }
}
