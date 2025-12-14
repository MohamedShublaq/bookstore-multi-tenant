<?php

namespace App\Http\Requests\Website;

use App\Rules\UniqueInLibrary;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', new UniqueInLibrary('users', 'email')],
            'full_phone' => ['required', 'phone:INTERNATIONAL', new UniqueInLibrary('users', 'phone')],
            'password' => ['required', 'string', 'min:6', 'max:255', 'confirmed'],
        ];
    }
}
