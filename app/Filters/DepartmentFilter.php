<?php

namespace App\Filters;

use Illuminate\Http\Request;

class DepartmentFilter
{
    protected $request;
    protected $builder;

    protected $filters = [
        'governorate',
        'city',
        'min_price',
        'max_price',
        'sort'
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

    private function filterGovernorate($value)
    {
        return $this->builder->where('location->governorate', $value);
    }

    private function filterCity($value)
    {
        return $this->builder->where('location->city', $value);
    }

    private function filterMin_price($value)
    {
        return $this->builder->where('rentFee', '>=', $value);
    }

    private function filterMax_price($value)
    {
        return $this->builder->where('rentFee', '<=', $value);
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

            default:
                return $this->builder;
        }
    }
}
