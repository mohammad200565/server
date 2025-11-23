<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'department_id' => 'required|exists:departments,id',
            'startRent'     => 'required|date',
            'endRent'       => 'required|date|after_or_equal:startRent',
            'rentFee'       => 'required|numeric|min:0',
        ];
    }
}
