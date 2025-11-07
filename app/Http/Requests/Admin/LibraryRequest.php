<?php

namespace App\Http\Requests\Admin;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class LibraryRequest extends FormRequest
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
        $library = $this->route('library');
        return [
            'library_name' => ['required', 'string', 'min:3', 'max:255'],
            'slug'         => ['required', 'string', 'min:3', 'max:255', Rule::unique('libraries', 'slug')->ignore($library)],
            'address'      => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:20'],
            'currency'     => ['required', 'string', 'max:20'],
            'logo'         => ['nullable', 'image', 'max:2048'],
            'admin_name'   => ['required', 'string', 'min:3', 'max:255'],
            'email'        => ['required', 'email', 'max:255'],
        ];
    }
}
