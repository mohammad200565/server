<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {
        return [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'birthdate'      => 'required|date',
            'location'       => 'required|string',
            'phone'          => 'required|string|unique:users,phone',
            'password'       => 'required|string|min:8|confirmed',
            'profileImage'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'personIdImage'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}
