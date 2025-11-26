<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'rentFee' => 'required|numeric',
            'isAvailable' => 'required|boolean',
            'status' => 'required|string',
            'size' => 'required|integer',
            'location.governorate' => 'required|string',
            'location.city' => 'required|string',
            'location.district' => 'nullable|string',
            'location.street' => 'nullable|string',
        ];
    }
}
