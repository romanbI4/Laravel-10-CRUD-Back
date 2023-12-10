<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email', 'max:254'],
            'password' => ['required', 'min:8', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => ' Email not found'
        ];
    }
}
