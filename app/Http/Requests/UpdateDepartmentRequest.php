<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'sometimes|string',
            'area' => 'sometimes|numeric',
            'rentFee' => 'sometimes|numeric',
            'headDescription' => 'sometimes|nullable|string',
            'isAvailable' => 'sometimes|boolean',
            'status' => 'sometimes|in:furnished,unfurnished,partially furnished',
            'bedrooms' => 'sometimes|integer|min:0',
            'bathrooms' => 'sometimes|integer|min:0',
            'floor' => 'sometimes|integer',
            'location.governorate' => 'sometimes|string',
            'location.city' => 'sometimes|string',
            'location.district' => 'sometimes|nullable|string',
            'location.street' => 'sometimes|nullable|string',
            'images' => 'sometimes|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
