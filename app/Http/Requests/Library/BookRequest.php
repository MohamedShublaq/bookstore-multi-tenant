<?php

namespace App\Http\Requests\Library;

use App\Rules\BelongsToLibrary;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'name'         => ['required', 'string', 'max:255'],
            'image'        => ['nullable', 'image', 'max:2048'],
            'description'  => ['nullable', 'string'],
            'total_stock'  => ['required', 'integer', 'min:1'],
            'pages'        => ['required', 'integer'],
            'rate'         => ['required', 'numeric', 'min:0', 'max:5'],
            'publish_year' => ['required', 'integer'],
            'price'        => ['required', 'numeric', 'min:0'],
            'category_id'  => ['required', new BelongsToLibrary('categories')],
            'language_id'  => ['required', new BelongsToLibrary('languages')],
            'publisher_id' => ['required', new BelongsToLibrary('publishers')],
            'author_id'    => ['required', new BelongsToLibrary('authors')],
        ];
    }
}
