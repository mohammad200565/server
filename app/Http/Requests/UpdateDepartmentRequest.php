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
            'description' => 'required|string',
            'rentFee' => 'required|numeric',
            'isAvailable' => 'required|boolean',
            'status' => 'required|string',
        ];
    }
}
