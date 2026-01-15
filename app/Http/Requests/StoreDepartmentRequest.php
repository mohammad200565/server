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
            'description' => 'string',
            'area' => 'required|numeric',
            'headDescription' => 'nullable|string',
            'rentFee' => 'required|numeric',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'floor' => 'required|integer',
            'location' => 'required',
            'location.governorate' => 'required|string',
            'location.city' => 'required|string',
            'location.district' => 'nullable|string',
            'location.street' => 'nullable|string',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpg,jpeg,png',
        ];
    }
}
