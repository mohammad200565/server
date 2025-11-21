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
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
            'rentFee' => 'required|numeric',
            'isAvailable' => 'required|boolean',
            'status' => 'required|string',
            'size' => 'required|integer',
            'location' => 'required|string',
        ];
    }
}
