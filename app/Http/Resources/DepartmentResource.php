<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DepartmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'description' => $this->resource->description,
            'headDescription' => $this->resource->headDescription,
            'area' => $this->resource->area,
            'bedrooms' => $this->resource->bedrooms,
            'bathrooms' => $this->resource->bathrooms,
            'floor' => $this->resource->floor,
            'rentFee' => $this->resource->rentFee,
            'isAvailable' => $this->resource->isAvailable,
            'verification_state' => $this->resource->isAvailable,
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'average_rating' => $this->resource->average_rating,
            'review_count' => $this->resource->review_count,
            'rentCounter' => $this->resource->rentCounter,
            'location' => [
                'governorate' => $this->resource->location['governorate'] ?? null,
                'city' => $this->resource->location['city'] ?? null,
                'district' => $this->resource->location['district'] ?? null,
                'street' => $this->resource->location['street'] ?? null,
            ],
        ];

        if ($this->resource->relationLoaded('images')) {
            $data['images'] = $this->resource->images->map(
                fn($img) =>
                $img->path ? Storage::url($img->path) : null
            );
        }

        if ($this->resource->relationLoaded('user')) {
            $data['user'] = new UserResource($this->resource->user);
        }

        if ($this->resource->relationLoaded('reviews')) {
            $data['reviews'] = ReviewResource::collection($this->resource->reviews);
        }
        if ($this->resource->relationLoaded('comments')) {
            $data['comments'] = CommentResource::collection($this->resource->comments);
        }
        if ($this->resource->relationLoaded('rents')) {
            $rents = $this->resource->rents;
            $data['rents'] = RentResource::collection($rents);
            $rents = $rents->where('status', 'onRent')->sortBy('startRent');
            $data['free_times'] = $this->calculateFreeTimes($rents);
        }
        return $data;
    }
    protected function calculateFreeTimes($rents)
    {
        $now = now();
        if ($rents->isEmpty()) {
            return [[
                'start_time' => $now->toDateTimeString(),
                'end_time' => null,
            ]];
        }
        $rents = $rents->sortBy('startRent')->values();
        $freeTimes = [];
        $firstStart  = Carbon::parse($rents->first()->startRent)->startOfDay();
        $previousEnd = Carbon::parse($rents->first()->endRent)->endOfDay();
        if ($now->lt($firstStart)) {
            $freeTimes[] = [
                'start_time' => $now->toDateTimeString(),
                'end_time'   => $firstStart->toDateTimeString(),
            ];
        }
        foreach ($rents->skip(1) as $rent) {
            $start = Carbon::parse($rent->startRent)->startOfDay();
            $end   = Carbon::parse($rent->endRent)->endOfDay();

            if ($start->gt($previousEnd->copy()->addSecond())) {
                $freeTimes[] = [
                    'start_time' => $previousEnd->copy()->addSecond()->toDateTimeString(),
                    'end_time'   => $start->toDateTimeString(),
                ];
            }
            if ($end->gt($previousEnd)) {
                $previousEnd = $end;
            }
        }
        $freeTimes[] = [
            'start_time' => $previousEnd->copy()->addSecond()->toDateTimeString(),
            'end_time'   => null,
        ];
        return $freeTimes;
    }
}
