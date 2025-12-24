<?php

namespace App\Filters;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentFilter
{
    protected $request;
    protected $builder;

    protected $filters = [
        'governorate',
        'city',
        'district',
        'street',
        'min_price',
        'max_price',
        'sort',
        'bedrooms',
        'bathrooms',
        'floor',
        'min_area',
        'max_area',
        'user',
        'search'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->filters as $filter) {
            $value = $this->request->query($filter);
            if (!is_null($value)) {
                $method = 'filter' . ucfirst($filter);
                if (method_exists($this, $method)) {
                    $this->$method($value);
                }
            }
        }

        return $this->builder;
    }

    private function filterUser($value)
    {
        return $this->builder->where('user_id', $value);
    }
    private function filterBedrooms($value)
    {
        return $this->builder->where('bedrooms', $value);
    }
    private function filterBathrooms($value)
    {
        return $this->builder->where('bathrooms', $value);
    }
    private function filterFloor($value)
    {
        return $this->builder->where('floor', $value);
    }
    private function filterMin_area($value)
    {
        return $this->builder->where('area', '>=', $value);
    }
    private function filterMax_area($value)
    {
        return $this->builder->where('area', '<=', $value);
    }
    private function filterGovernorate($value)
    {
        return $this->builder->where('location->governorate', $value);
    }
    private function filterCity($value)
    {
        return $this->builder->where('location->city', $value);
    }
    private function filterDistrict($value)
    {
        return $this->builder->where('location->district', $value);
    }
    private function filterStreet($value)
    {
        return $this->builder->where('location->street', $value);
    }

    private function filterMin_price($value)
    {
        return $this->builder->where('rentFee', '>=', $value);
    }

    private function filterMax_price($value)
    {
        return $this->builder->where('rentFee', '<=', $value);
    }
    public function filterSearch($value)
    {
        return $this->builder->where(function ($q) use ($value) {
            $q->where('headDescription', 'LIKE', "%{$value}%")
                ->orWhere('description', 'LIKE', "%{$value}%");
        });
    }
    private function filterSort($value)
    {
        switch ($value) {
            case 'price_asc':
                return $this->builder->orderBy('rentFee', 'asc');

            case 'price_desc':
                return $this->builder->orderBy('rentFee', 'desc');

            case 'date_asc':
                return $this->builder->orderBy('created_at', 'asc');

            case 'date_desc':
                return $this->builder->orderBy('created_at', 'desc');

            case 'rating_desc':
                return $this->builder
                    ->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', 'desc');

            case 'rating_asc':
                return $this->builder
                    ->withAvg('reviews', 'rating')
                    ->orderBy('reviews_avg_rating', 'asc');

            case 'reviews_desc':
                return $this->builder
                    ->withCount('reviews')
                    ->orderBy('reviews_count', 'desc');

            case 'reviews_asc':
                return $this->builder
                    ->withCount('reviews')
                    ->orderBy('reviews_count', 'asc');

            case 'rentcounter_desc':
                return $this->builder->orderBy('rentCounter', 'desc');

            case 'rentcounter_asc':
                return $this->builder->orderBy('rentCounter', 'asc');

            default:
                return $this->builder;
        }
    }
}
