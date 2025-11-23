<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'department_id' => 'sometimes|exists:departments,id',
            'startRent'     => 'sometimes|date',
            'endRent'       => 'sometimes|date|after_or_equal:startRent',
            'rentFee'       => 'sometimes|numeric|min:0',
            'status'        => 'sometimes|in:pending,approved,cancelled,completed',
        ];
    }
}
