<?php

namespace App\Http\Requests\Library;

use App\Enums\DiscountType;
use App\Rules\BelongsToLibrary;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class FlashSaleRequest extends FormRequest
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
        $flashSale = $this->route('flash_sale');
        $isUpdate = $flashSale !== null;
        $now = Carbon::now();

        return [
            'discount_type' => ['required', new Enum(DiscountType::class)],
            'discount_value' => ['required', 'numeric', 'min:1'],
            'books'  => ['nullable', 'array'],
            'books.*'  => [new BelongsToLibrary('books')],
            'categories'  => ['nullable', 'array'],
            'categories.*'  => [new BelongsToLibrary('categories')],
            'start_at' => [
                'required',
                'date',
                Rule::when(! $isUpdate, ['after_or_equal:' . $now]),
            ],
            'end_at' => [
                'required',
                'date',
                'after:start_at',
            ],
            'applies_to_all_books' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $appliesToAll = $this->boolean('applies_to_all_books');

            if (! $appliesToAll) {
                $hasBooks = is_array($this->books) && count($this->books) > 0;
                $hasCategories = is_array($this->categories) && count($this->categories) > 0;

                if (! $hasBooks && ! $hasCategories) {
                    $validator->errors()->add('books', 'You must select at least one book or category when the coupon is not for all books.');
                    $validator->errors()->add('categories', 'You must select at least one book or category when the coupon is not for all books.');
                }
            }
        });
    }
}
