<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
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

        if ($this->resource->relationLoaded('user')) {
            $data['user'] = new UserResource($this->resource->user);
        }
        if ($this->relationLoaded('department')) {
            $department = $this->department;

            if ($department->relationLoaded('rents')) {
                $department->free_times =
                    $this->calculateFreeTimes($department->rents);
            }
            $data['department'] = new DepartmentResource($department);
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
