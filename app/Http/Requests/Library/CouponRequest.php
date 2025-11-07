<?php

namespace App\Http\Requests\Library;

use App\Enums\DiscountType;
use App\Rules\BelongsToLibrary;
use App\Rules\UniqueInLibrary;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponRequest extends FormRequest
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
        $coupon = $this->route('coupon');
        $isUpdate = $coupon !== null;
        $today = Carbon::today()->toDateString();

        return [
            'code' => [
                'required',
                'string',
                'max:255',
                new UniqueInLibrary('coupons', 'code', $coupon),
            ],
            'discount_type' => ['required', new Enum(DiscountType::class)],
            'discount_value' => ['required', 'numeric', 'min:1'],
            'books'  => ['nullable', 'array'],
            'books.*'  => [new BelongsToLibrary('books')],
            'categories'  => ['nullable', 'array'],
            'categories.*'  => [new BelongsToLibrary('categories')],
            'start_date' => [
                'nullable',
                'date',
                'required_with:end_date',
                Rule::when(! $isUpdate, ['after_or_equal:' . $today]),
            ],
            'end_date' => [
                'nullable',
                'date',
                'required_with:start_date',
                'after:start_date',
            ],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'per_user_limit' => ['nullable', 'integer', 'min:1'],
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
