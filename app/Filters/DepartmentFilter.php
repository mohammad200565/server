<?php

namespace App\Filters;

use Illuminate\Http\Request;

class DepartmentFilter
{
    protected $request;
    protected $builder;

    protected $filters = [
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

    private function filterCity($value)
    {
        return $this->builder->where('location', $value);
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
        if ($value === 'price_asc') {
            return $this->builder->orderBy('rentFee', 'asc');
        }

        if ($value === 'price_desc') {
            return $this->builder->orderBy('rentFee', 'desc');
        }
    }
}
