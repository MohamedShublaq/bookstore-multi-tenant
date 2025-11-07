<?php

namespace App\Http\Requests\Library;

use App\Rules\UniqueInLibrary;
use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
        $admin = $this->route('admin');
        return [
            'name'   => ['required', 'string', 'min:3', 'max:255'],
            'email'  => [
                'required',
                'email',
                'max:255',
                new UniqueInLibrary('library_admins', 'email', $admin),
            ],
        ];
    }
}
